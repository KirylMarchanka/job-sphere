<?php

namespace App\Http\Controllers\Resume\User;

use App\Components\Responser\Facades\Responser;
use App\Components\Resume\Contacts\Enums\ResumeContactPreferredContactEnum;
use App\Components\Resume\DTOs\ResumeContactDto;
use App\Components\Resume\DTOs\ResumeContactOtherSourceDto;
use App\Components\Resume\DTOs\ResumeDto;
use App\Components\Resume\DTOs\ResumeEducationDto;
use App\Components\Resume\DTOs\ResumePersonalInformationDto;
use App\Components\Resume\DTOs\ResumeSkillDto;
use App\Components\Resume\DTOs\ResumeSpecializationDto;
use App\Components\Resume\DTOs\ResumeWorkExperienceDto;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Enums\StatusEnum;
use App\Components\Resume\Education\Enums\DegreeEnum;
use App\Components\Resume\Personal\Enums\SexEnum;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resume\User\DeleteResumeRequest;
use App\Http\Requests\Resume\User\StoreResumeRequest;
use App\Http\Requests\Resume\User\UpdateResumeRequest;
use App\Models\Resume;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class ResumeController extends Controller
{
    public function index(Request $request, ResumeRepository $repository): JsonResponse
    {
        $resumes = $repository->setUser($request->user())->all();

        return empty($resumes)
            ? Responser::setHttpCode(Response::HTTP_NOT_FOUND)->error(Lang::get('user.resumes.list_not_found'))
            : Responser::setData($resumes)->success();
    }

    public function show(Request $request, string $resume, ResumeRepository $repository): JsonResponse
    {
        $resume = $repository->setUser($request->user())->find($resume);

        return null === $resume
            ? Responser::setHttpCode(Response::HTTP_NOT_FOUND)->error(Lang::get('user.resumes.single_not_found'))
            : Responser::setData($resume)->success();
    }

    public function store(StoreResumeRequest $request, ResumeRepository $repository): JsonResponse
    {
        $repository->setUser($request->user())->store(
            new ResumeDto(
                $request->input('title'),
                StatusEnum::from($request->integer('status')),
                $request->input('salary'),
                EmploymentEnum::from($request->integer('employment')),
                ScheduleEnum::from($request->integer('schedule')),
                $request->input('description')
            ),
            $request->whenFilled('specializations', fn(array $specializations) => array_map(fn(int $specialization) => new ResumeSpecializationDto($specialization), $specializations), fn() => []),
            $request->whenFilled('skills', fn(array $skills) => array_map(fn(int $skill) => new ResumeSkillDto($skill), $skills), fn() => []),
            new ResumeContactDto(...$request->input('contact')), //@todo preferred_contact_source проверка на заполненность указанного источника
            new ResumePersonalInformationDto(...$request->input('personal_information')),
            $request->whenFilled('education', fn(array $educations) => array_map(fn(array $education) => new ResumeEducationDto(...$education), $educations), fn() => []),
            $request->whenFilled('work_experience', fn(array $workExperiences) => array_map(fn(array $workExperience) => new ResumeWorkExperienceDto(...$workExperience), $workExperiences), fn() => []),
        );

        return Responser::setData(['success' => true])->setHttpCode(Response::HTTP_CREATED)->success();
    }

    public function update(UpdateResumeRequest $request, Resume $resume, ResumeRepository $repository): JsonResponse
    {
        //@todo Вынести куда-либо?
        $repository->setUser($request->user())->update(
            $resume->getKey(),
            new ResumeDto(
                $request->input('title', $resume->getAttribute('title')),
                StatusEnum::from($request->integer('status', $resume->getRawOriginal('status'))),
                $request->input('salary', $resume->getAttribute('salary')),
                EmploymentEnum::from($request->integer('employment', $resume->getRawOriginal('employment'))),
                ScheduleEnum::from($request->integer('schedule', $resume->getRawOriginal('schedule'))),
                $request->input('description', $resume->getAttribute('description'))
            ),
            $request->whenHas('specializations', fn(array $specializations) => array_map(fn(int $specialization) => new ResumeSpecializationDto($specialization), $specializations), fn() => null),
            $request->whenHas('skills', fn(array $skills) => array_map(fn(int $skill) => new ResumeSkillDto($skill), $skills), fn() => null),
            $request->whenHas('contact', function (array $contact) use ($request, $resume) {
                $resumeContact = $resume->load('contact')->getRelation('contact');

                return new ResumeContactDto(
                    $contact['mobile_number'] ?? $resumeContact->getAttribute('mobile_number'),
                    $contact['comment'] ?? $resumeContact->getAttribute('comment'),
                    $contact['email'] ?? $resumeContact->getAttribute('email'),
                    ResumeContactPreferredContactEnum::from($contact['preferred_contact_source'] ?? $resumeContact->getRawOriginal('preferred_contact_source')),
                    new ResumeContactOtherSourceDto(
                        ...($contact['other_sources'] ?? $resumeContact->getAttribute('other_sources'))
                    ),
                );
            }, fn() => null),
            $request->whenHas('personal_information', function (array $personalInformation) use ($request, $resume) {
                $resumePersonalInfo = $resume->load('personalInformation')->getRelation('personalInformation');

                return new ResumePersonalInformationDto(
                    $personalInformation['name'] ?? $resumePersonalInfo->getAttribute('name'),
                    $personalInformation['surname'] ?? $resumePersonalInfo->getAttribute('surname'),
                    $personalInformation['middle_name'] ?? $resumePersonalInfo->getAttribute('middle_name'),
                    Carbon::parse($personalInformation['birthdate'] ?? $resumePersonalInfo->getRawOriginal('birthdate')),
                    SexEnum::from($personalInformation['sex'] ?? $resumePersonalInfo->getRawOriginal('sex')),
                    $personalInformation['city_id'] ?? $resumePersonalInfo->getAttribute('city_id'),
                );
            }, fn() => null),
            $request->whenHas('education', function (array $education) use ($request, $resume) {
                $resumeEducation = $resume->loadMissing('education')->getRelation('education');

                return array_filter(array_map(function (array $education) use ($resumeEducation) {
                    if (isset($education['id']) && $resumeEducation->where('id', $education['id'])->isEmpty()) {
                        return null;
                    }

                    if (!isset($education['id'])) {
                        return new ResumeEducationDto(
                            $education['educational_institution_id'],
                            $education['department'],
                            $education['specialization'],
                            DegreeEnum::from($education['degree']),
                            Carbon::parse($education['start_date']),
                            Carbon::parse($education['end_date']),
                        );
                    }

                    $currentResumeEducation = $resumeEducation->where('id', $education['id'])->first();

                    return new ResumeEducationDto(
                        $education['educational_institution_id'] ?? $currentResumeEducation->getAttribute('educational_institution_id'),
                        $education['department'] ?? $currentResumeEducation->getAttribute('department'),
                        $education['specialization'] ?? $currentResumeEducation->getAttribute('specialization'),
                        DegreeEnum::from($education['degree'] ?? $currentResumeEducation->getRawOriginal('degree')),
                        Carbon::parse($education['start_date'] ?? $currentResumeEducation->getRawOriginal('start_date')),
                        Carbon::parse($education['end_date'] ?? $currentResumeEducation->getRawOriginal('end_date')),
                        $currentResumeEducation->getAttribute('id'),
                    );
                }, $education));
            }, fn() => null),
            $request->whenHas('work_experiences', function (array $workExperience) use ($request, $resume) {
                $resumeWorkExperience = $resume->loadMissing('workExperiences')->getRelation('workExperiences');

                return array_filter(array_map(function (array $workExperience) use ($resumeWorkExperience) {
                    if (isset($workExperience['id']) && $resumeWorkExperience->where('id', $workExperience['id'])->isEmpty()) {
                        return null;
                    }

                    if (!isset($workExperience['id'])) {
                        return new ResumeWorkExperienceDto(
                            $workExperience['company_name'],
                            $workExperience['city_id'],
                            $workExperience['position'],
                            $workExperience['site_url'],
                            $workExperience['description'],
                            Carbon::parse($workExperience['from']),
                            null === $workExperience['to'] ? $workExperience['to'] : Carbon::parse($workExperience['to']),
                        );
                    }

                    $currentResumeWorkExperience = $resumeWorkExperience->where('id', $workExperience['id'])->first();

                    if (array_key_exists('to', $workExperience)) {
                        $to = null === $workExperience['to'] ? null : Carbon::parse($workExperience['to']);
                    } else {
                        $to = Carbon::parse($currentResumeWorkExperience->getRawOriginal('to'));
                    }

                    return new ResumeWorkExperienceDto(
                        $workExperience['company_name'] ?? $currentResumeWorkExperience->getAttribute('company_name'),
                        $workExperience['city_id'] ?? $currentResumeWorkExperience->getAttribute('city_id'),
                        $workExperience['position'] ?? $currentResumeWorkExperience->getAttribute('position'),
                        $workExperience['site_url'] ?? $currentResumeWorkExperience->getAttribute('site_url'),
                        $workExperience['description'] ?? $currentResumeWorkExperience->getAttribute('description'),
                        Carbon::parse($workExperience['from'] ?? $currentResumeWorkExperience->getRawOriginal('from')),
                        $to,
                        $currentResumeWorkExperience->getAttribute('id')
                    );
                }, $workExperience));
            }, fn() => null),
        );

        return Responser::setData(['success' => true])->setHttpCode(Response::HTTP_CREATED)->success();
    }

    public function delete(DeleteResumeRequest $request, Resume $resume, ResumeRepository $repository): JsonResponse
    {
        $repository->setUser($request->user())->delete($resume->getKey());

        return Responser::setData(['success' => true])->success();
    }
}
