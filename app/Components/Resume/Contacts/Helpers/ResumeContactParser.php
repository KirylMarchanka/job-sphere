<?php

namespace App\Components\Resume\Contacts\Helpers;

class ResumeContactParser
{
    public static function parse(array $contacts): array
    {
        $parsedContacts = [];
        foreach ($contacts as $key => $contact) {
            $parsedContacts[$key] = sprintf('%s/%s', config("socials.$key"), $contact);
        }

        return $parsedContacts;
    }
}
