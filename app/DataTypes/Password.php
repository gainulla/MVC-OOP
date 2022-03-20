<?php

namespace App\DataTypes;

final class Password extends DataType
{
    public function __construct(string $password)
    {
        if (!preg_match('/[a-z]/', $password)) {
            $this->errors[] = 'Пароль должен содержать маленькую букву.';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $this->errors[] = 'Пароль должен содержать большую букву.';
        }
        if (!preg_match('/\d/', $password)) {
            $this->errors[] = 'Пароль должен содержать цифру.';
        }
        if (strlen($password) < 6 || strlen($password) > 20) {
            $this->errors[] = 'Длина пароля должна быть не менее 6-ти и не более 20-ти знаков.';
        }

        if (empty($this->errors)) {
            $this->value = $password;
        }
    }
}
