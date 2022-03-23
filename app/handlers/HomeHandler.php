<?php

namespace App\Handlers;

class HomeHandler extends Handler
{
    public function index()
    {
        $this->renderer->render('home', [
            'user' => $this->user
        ]);
    }
}
