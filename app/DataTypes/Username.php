<?php

namespace App\DataTypes;

final class Username extends DataType
{
    public function __construct(string $username)
    {
        $allowed = array('-', '_');

        if (strlen($username) < 4 || strlen($username) > 20) {
            $this->errors[] = "Введите не менее 4-ых и не более 20-ти знаков.";
        }

        if (!ctype_alnum(str_replace($allowed, '', $username))) {
            $this->errors[] = "Можно вводить только буквы, цифры и знаки '-', '_'.";
        }

        if (empty($this->errors)) {
            $this->value = $username;
        }
    }
}
