<?php

namespace App\Handlers;

use App\Core\Renderer;
use App\Core\UrlManager;
use App\Core\SessionManager;
use App\Core\Auth;

class Handler
{
    protected $renderer;
    protected $session;
    protected $url;
    protected $auth;
    protected $params;

    public function __construct(
        Renderer $renderer,
        SessionManager $session,
        Auth $auth,
        UrlManager $url,
        array $params
    )
    {
        $this->renderer = $renderer;
        $this->session = $session;
        $this->auth = $auth;
        $this->url = $url;
        $this->params = $params;
    }

    protected function redirect($urlPath)
    {
        header("Location: " . $this->url->for($urlPath));
    }

    protected function params(string $key="")
    {
        if ($key != "") {
            if (!isset($this->params[$key])) {
                throw new \Exception("Parameter '$key' does not exists!");
            }
            return $this->params[$key];
        }

        return $this->params;
    }
}
