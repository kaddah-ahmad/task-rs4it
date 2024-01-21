<?php

namespace App\Dto;

class CraeteCompetitionDto
{
    public ?string $title;

    public ?string $description;

    public ?string $image;

    public function __construct(string $title, string $description, string $image)
    {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
    }
}
