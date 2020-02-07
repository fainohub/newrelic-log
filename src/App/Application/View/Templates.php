<?php

namespace App\Application\View;

final class Templates
{
    private $slug;

    public function __construct(?string $slug)
    {
        $this->slug = $slug;
    }

    public function getText()
    {
        $templates = [
            'test' => true
        ];

        return $templates[$this->slug];
    }
}