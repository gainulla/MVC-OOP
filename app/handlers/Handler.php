<?php

namespace App\Handlers;

use App\Core\Renderer;
use App\Core\UrlManager;
use App\Core\SessionManager;
use App\Models\UserModel;

class Handler
{
    protected $renderer;
    protected $session;
    protected $url;
    protected $user;
    protected $params;

    public function __construct(
        Renderer $renderer,
        SessionManager $session,
        UserModel $user,
        UrlManager $url,
        array $params
    ) {
        $this->renderer = $renderer;
        $this->session = $session;
        $this->user = $user;
        $this->url = $url;
        $this->params = $params;
    }

    protected function redirect($urlPath)
    {
        header("Location: " . $this->url->for($urlPath));
    }

    protected function getParam($index)
    {
        return (isset($this->params[$index]) ? $this->params[$index] : null);
    }
}
