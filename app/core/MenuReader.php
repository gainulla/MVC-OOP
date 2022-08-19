<?php

namespace App\Core;

use App\Core\UrlManager;

class MenuReader
{
    public function read(UrlManager $url, bool $isLoggedIn)
    {
        $menu = [];
        //$menu[] = ['url' => $url->for('/'), 'text' => ''];

        if (!$isLoggedIn) {
            $menu[] =['url' => $url->for('auth/login'), 'text' => 'Логин'];
        } else {
            $menu[] =['url' => $url->for('auth/logout'), 'text' => 'Выход'];
        }

        return $menu;
    }
}
