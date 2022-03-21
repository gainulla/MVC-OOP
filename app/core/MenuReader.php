<?php

namespace App\Core;

use App\Core\Url;

class MenuReader
{
    public function read(Url $url, $loggedInUser)
    {
        $menu = [];
        $menu[] = ['url' => $url->for('home/'), 'text' => 'Домашняя'];

        if (!$loggedInUser) {
            $menu[] = ['url' => $url->for('auth/register'), 'text' => 'Регистрация'];
            $menu[] =['url' => $url->for('auth/login'), 'text' => 'Вход'];
        } else {
            $menu[] =['url' => $url->for('auth/logout'), 'text' => 'Выход'];
        }

        return $menu;
    }
}
