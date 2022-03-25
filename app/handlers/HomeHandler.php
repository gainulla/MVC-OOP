<?php

namespace App\Handlers;

class HomeHandler extends Handler
{
    public function index()
    {
        $successMessage = $this->session->get('success', true);

        $this->renderer->render('home', [
            'user'           => $this->user,
            'successMessage' => $successMessage
        ]);
    }
}
