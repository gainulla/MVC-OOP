<?php

namespace App\DataTypes;

final class Email extends DataType
{
    public function __construct(string $emailAddress)
    {
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Некорректный эл. адрес.';
        }

        if (empty($this->errors)) {
            $this->value = $emailAddress;
        }
    }
}
