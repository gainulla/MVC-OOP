<?php

namespace App\DataTypes;

abstract class DataType
{
    protected $value;
    protected $errors = [];

    public function hasErrors()
    {
        return (count($this->errors) != 0);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getValue()
    {
        return $this->value;
    }
}
