<?php

namespace App\Handlers;

class HomeHandler extends Handler
{
    public function index(array $params)
    {
        $this->renderer->render('home', [
            'username' => $this->session->get('username')
        ]);
    }
}
