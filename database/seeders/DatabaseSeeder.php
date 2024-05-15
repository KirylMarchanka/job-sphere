<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
use App\Models\EducationalInstitution;
use App\Models\Employer;
use App\Models\EmployerJob;
use App\Models\Resume;
use App\Models\ResumeContact;
use App\Models\ResumeEducation;
use App\Models\ResumePersonalInformation;
use App\Models\ResumeWorkExperience;
use App\Models\Skill;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Specialization::factory(10)->create();
        Skill::factory(10)->create();

//        Employer::factory(10)->afterCreating(function (Employer $employer) {
//            $limit = rand(0, 5);
//            if ($limit === 0) {
//                return;
//            }
//
//            EmployerJob::factory($limit)->for($employer)->afterCreating(function (EmployerJob $employerJob) {
//                $limit = rand(1, 5);
//                $employerJob->skills()->attach(Skill::query()->inRandomOrder()->limit($limit)->pluck('id')->toArray());
//            })->create();
//        })->create();
//
//         User::factory(10)->afterCreating(function (User $user) {
//             $limit = rand(0, 2);
//             if ($limit === 0) {
//                 return;
//             }
//
//             Resume::factory($limit)->for($user)->afterCreating(function (Resume $resume) {
//                 $limit = rand(1, 5);
//
//
//                 ResumeEducation::factory($limit)->for($resume)->create();
//                 ResumeContact::factory()->for($resume)->create();
//                 ResumePersonalInformation::factory()->for($resume)->create();
//                 ResumeWorkExperience::factory($limit)->for($resume)->create();
//
//                 $resume->skills()->attach(Skill::query()->inRandomOrder()->limit($limit)->pluck('id')->toArray());
//                 $resume->specializations()->attach(Specialization::query()->inRandomOrder()->limit($limit)->pluck('id')->toArray());
//             })->create();
//         })->create();
    }
}
