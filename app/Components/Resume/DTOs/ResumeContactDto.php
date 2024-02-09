<?php

namespace App\Components\Resume\DTOs;

use App\Components\Resume\Contacts\Enums\ResumeContactPreferredContactEnum;

class ResumeContactDto
{
    public string $mobileNumber;
    public ?string $comment;
    public ?string $email;
    public ResumeContactPreferredContactEnum $preferredContactSource;
    public ResumeContactOtherSourceDto $otherSources;

    public function __construct(
        string $mobileNumber,
        ?string $comment,
        ?string $email,
        ResumeContactPreferredContactEnum $preferredContactSource,
        ResumeContactOtherSourceDto $otherSources
    )
    {
        $this->mobileNumber = $mobileNumber;
        $this->comment = $comment;
        $this->email = $email;
        $this->preferredContactSource = $preferredContactSource;
        $this->otherSources = $otherSources;
    }

    public function toArray(): array
    {
        return [
            'mobile_number' => $this->mobileNumber,
            'comment' => $this->comment,
            'email' => $this->email,
            'preferred_contact_source' => $this->preferredContactSource->value,
            'other_sources' => $this->otherSources->toArray(),
        ];
    }
}
