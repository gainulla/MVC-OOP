<?php

namespace App\Models;

use App\DataTypes\Email;
use App\DataTypes\Username;
use App\DataTypes\Password;

class UserModel
{
    private $id;
    private $email;
    private $username;
    private $passwordHash;

    public function __construct(array $data=[])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? NULL;
            $this->email = $data['email'] ?? NULL;
            $this->username = $data['username'] ?? NULL;
            $this->passwordHash = (isset($data['password']) && $data['password'])
                                ? password_hash($data['password'], PASSWORD_BCRYPT)
                                : NULL;
        }
    }

    public function isLoggedIn()
    {
        return $this->id !== NULL;
    }

    public function getAttr(string $attr)
    {
        return $this->{$attr};
    }

    public static function formLabels(): array
    {
        return [
            'email' => 'Эл. адрес',
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function validationRules(): array
    {
        return [
            'email'         => [
                                'required',
                                ['dataType' => Email::class],
                                'unique'
                              ],
            'username'      => [
                                'required',
                                ['dataType' => Username::class],
                                'unique'
                              ],
            'password'   => [
                                'required',
                                ['dataType' => Password::class]
                            ]
        ];
    }
}
