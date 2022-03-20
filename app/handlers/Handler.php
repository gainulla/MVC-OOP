<?php

namespace App\Handlers;

use App\Core\Renderer;
use App\Core\SessionManager;

class Handler
{
    protected $renderer;
    protected $session;

    public function __construct(Renderer $renderer, SessionManager $session)
    {
        $this->renderer = $renderer;
        $this->session = $session;
    }

    protected function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }

    protected function redirect($urlPath)
    {
        header("Location: " . BASE_URL . ltrim($urlPath, '/'));
    }
}
