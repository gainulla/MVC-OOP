<?php

namespace App\Contracts;

interface ModelInterface
{
    public function attr(string $attr);

    public function validationRules(): array;

    public static function formLabels(): array;
}
