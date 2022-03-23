<?php

namespace App\Models;

use App\DataTypes\Email;
use App\DataTypes\Username;
use App\DataTypes\Password;

class UserModel implements \App\Contracts\ModelInterface
{
    protected $id;
    protected $email;
    protected $username;
    protected $passwordHash;
    protected $passwordResetHash;
    protected $passwordResetExpiresAt;

    public function __construct(array $data=[])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? NULL;
            $this->email = $data['email'] ?? NULL;
            $this->username = $data['username'] ?? NULL;
            $this->passwordHash = (isset($data['password']) && $data['password'])
                                ? password_hash($data['password'], PASSWORD_BCRYPT)
                                : NULL;
            $this->passwordResetHash = $data['passwordResetHash'] ?? NULL;
            $this->passwordResetExpiresAt = $data['passwordResetExpiresAt'] ?? NULL;
        }
    }

    public function isLoggedIn()
    {
        return $this->id !== NULL;
    }

    public function attr(string $attr)
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
