<?php

namespace App\Models;

use App\DataTypes\Email;
use App\DataTypes\Username;
use App\DataTypes\Password;

final class UserModel implements \App\Contracts\ModelInterface
{
    protected $id = NULL;
    protected $email = NULL;
    protected $username = NULL;
    protected $passwordHash = NULL;
    protected $passwordResetHash = NULL;
    protected $passwordResetExpiresAt = NULL;

    public function __construct(array $data=[])
    {
        if (!empty($data)) {
            $this->fill($data);
        }
    }

    public function fill(array $data): void
    {
        $this->id = $data['id'] ?? $this->id;

        $this->email = $data['email'] ?? $this->email;

        $this->username = $data['username'] ?? $this->username;

        $this->passwordHash = (isset($data['password']) && $data['password'])
                            ? password_hash($data['password'], PASSWORD_BCRYPT)
                            : $this->passwordHash;

        $this->passwordResetHash = $data['passwordResetHash'] ?? $this->passwordResetHash;

        $this->passwordResetExpiresAt = $data['passwordResetExpiresAt'] ?? $this->passwordResetExpiresAt;
    }

    public function attr(string $attr)
    {
        return $this->{$attr};
    }

    public function attrAll(): array
    {
        $attributes = [];

        foreach ($this as $prop => $value) {
            $attributes[$prop] = $value;
        }

        return $attributes;
    }

    public static function formFields(): array
    {
        return [
            'email'    => 'Эл. адрес',
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public static function validationRules(): array
    {
        return [
            'email'             => [
                                    'required',
                                    ['dataType' => Email::class],
                                    'unique'
                                ],
            'username'          => [
                                    'required',
                                    ['dataType' => Username::class],
                                    'unique'
                                ],
            'password'          => [
                                    'required',
                                    ['dataType' => Password::class]
                                ]
        ];
    }
}
