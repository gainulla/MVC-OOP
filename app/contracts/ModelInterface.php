<?php

namespace App\Contracts;

interface ModelInterface
{
    // Set model attribute(s)
    public function fill(array $data): void;

    // get model attribute
    public function attr(string $attr); // mixed

    // get all model attributes
    public function attrAll(): array;

    // define validation rules
    public function validationRules(): array;

    // define form labels
    public static function formLabels(): array;
}
