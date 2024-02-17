<?php

namespace App\Components\Resume\Helpers\DtoFillers;

use App\Components\Resume\Contacts\Enums\ResumeContactPreferredContactEnum;
use App\Components\Resume\Contacts\Helpers\ResumeContactPreferredValueChecker;
use App\Components\Resume\DTOs\ResumeContactDto;
use App\Components\Resume\DTOs\ResumeContactOtherSourceDto;
use App\Models\Resume;
use App\Models\ResumeContact;

class ResumeContactDtoFiller
{
    public static function fill(Resume $resume, ?array $contactData): ?ResumeContactDto
    {
        if (empty($contactData)) {
            return null;
        }

        $contact = $resume->loadMissing('contact')->getRelation('contact');

        return new ResumeContactDto(
            $contactData['mobile_number'] ?? $contact->getAttribute('mobile_number'),
            array_key_exists('comment', $contactData) ? $contactData['comment'] : $contact->getAttribute('comment'),
            array_key_exists('email', $contactData) ? $contactData['email'] : $contact->getAttribute('email'),
            self::getPreferredContactValue($contact, $contactData),
            array_key_exists('other_sources', $contactData)
                ? new ResumeContactOtherSourceDto(...$contactData['other_sources'])
                : new ResumeContactOtherSourceDto(...$contact->getAttribute('other_sources')),
        );
    }

    private static function getPreferredContactValue(ResumeContact $contact, array $contactData): ResumeContactPreferredContactEnum
    {
        if (!isset($contactData['preferred_contact_source'])) {
            return ResumeContactPreferredContactEnum::from($contact->getRawOriginal('preferred_contact_source'));
        }

        /** @var ResumeContactPreferredValueChecker $checker */
        $checker = app()->make(ResumeContactPreferredValueChecker::class);

        return $checker->checkFillings($contact, $contactData)
            ? ResumeContactPreferredContactEnum::from($contactData['preferred_contact_source'])
            : ResumeContactPreferredContactEnum::MOBILE_NUMBER;
    }
}
