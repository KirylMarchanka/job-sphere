<?php

namespace App\Components\Resume\Contacts\Helpers;

use App\Components\Resume\Contacts\Enums\ResumeContactPreferredContactEnum;
use App\Models\ResumeContact;

class ResumeContactPreferredValueChecker
{
    public function checkFillings(?ResumeContact $contact, array $contactData): bool
    {
        if (!isset($contactData['preferred_contact_source'])) {
            return false;
        }

        switch ($contactData['preferred_contact_source']) {
            case ResumeContactPreferredContactEnum::MOBILE_NUMBER->value:
                $isFilled = true;
                break;
            case ResumeContactPreferredContactEnum::EMAIL->value:
                if (isset($contactData['email'])) {
                    $isFilled = true;
                    break;
                }

                $isFilled = null !== $contact && null !== $contact->getAttribute('email');
                break;
            case ResumeContactPreferredContactEnum::LINKEDIN->value:
                if (isset($contactData['other_sources']['linkedin'])) {
                    $isFilled = true;
                    break;
                }

                $isFilled = null !== $contact && isset($contact->getAttribute('other_sources')['linkedin']);
                break;
            case ResumeContactPreferredContactEnum::TELEGRAM->value:
                if (isset($contactData['other_sources']['telegram'])) {
                    $isFilled = true;
                    break;
                }

                $isFilled = null !== $contact && isset($contact->getAttribute('other_sources')['telegram']);
                break;
            default:
                $isFilled = false;
                break;
        }

        return $isFilled;
    }
}
