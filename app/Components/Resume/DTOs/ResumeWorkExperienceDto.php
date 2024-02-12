<?php

namespace App\Components\Resume\DTOs;

use Carbon\Carbon;

class ResumeWorkExperienceDto
{
    public string $companyName;
    public int $cityId;
    public string $position;
    public ?string $siteUrl;
    public ?string $description;
    public Carbon $from;
    public ?Carbon $to;
    public ?int $id;

    public function __construct(
        string  $companyName,
        int     $cityId,
        string  $position,
        ?string $siteUrl,
        ?string $description,
        Carbon  $from,
        ?Carbon $to,
        ?int    $id = null,
    )
    {
        $this->companyName = $companyName;
        $this->cityId = $cityId;
        $this->position = $position;
        $this->siteUrl = $siteUrl;
        $this->description = $description;
        $this->from = $from;
        $this->to = $to;
        $this->id = $id;
    }

    public function toArray(): array
    {
        return [
            'company_name' => $this->companyName,
            'city_id' => $this->cityId,
            'position' => $this->position,
            'site_url' => $this->siteUrl,
            'description' => $this->description,
            'from' => $this->from->setDay(1)->format('Y-m-d'),
            'to' => $this->to?->setDay(1)->format('Y-m-d'),
        ];
    }
}
