<?php

namespace App\Contracts;

interface TemplateInterface
{
    public function template(string $templateFile, array $data): void;
}
