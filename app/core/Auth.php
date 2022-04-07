<?php

namespace App\Core;

use App\Models\UserModel;

class Auth
{
    private $user;

    public function __construct()
    {
        $this->user = NULL;
    }

    public function authenticate(UserModel $user)
    {
        session_regenerate_id(true);
        $this->user = $user;
    }

    public function isLoggedIn()
    {
        return $this->user !== NULL;
    }

    public function user()
    {
        return $this->user;
    }
}
