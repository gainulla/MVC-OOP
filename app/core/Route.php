<?php

namespace App\Core;

use App\Core\Renderer;
use App\Core\UrlManager;
use App\Core\SessionManager;
use App\Models\UserModel;

class Route
{
    // Default Handler
    private $currentHandler = '\App\Handlers\HomeHandler';

    // Default Action
    private $currentMethod  = 'index';

    // Params from URL path
    private $params         = [];

    public function __construct()
    {
        $url = $this->getUrl();

        if (empty($url)) {
            return;
        }

        $class = sprintf("\App\Handlers\%sHandler", ucwords($url[0]));

        if (class_exists($class)) {
            $this->currentHandler = $class;
            unset($url[0]);
        }

        if (isset($url[1])) {
            $method = '';

            if (strpos($url[1], '-') !== false) {
                $explode = explode('-', $url[1]);
                foreach ($explode as $x => $part) {
                    $method .= ($x == 0) ? $part : ucfirst($part);
                }
            } else {
                $method = $url[1];
            }
            if (method_exists($this->currentHandler, $method)) {
                $this->currentMethod = $method;
            }
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];
    }

    public function execute(
        Renderer $renderer,
        SessionManager $session,
        UserModel $user,
        UrlManager $url,
        $dependencies = []): void
    {
        call_user_func_array(
            [
                new $this->currentHandler($renderer, $session, $user, $url, $this->params),
                $this->currentMethod
            ],
            $dependencies
        );
    }

    public function handlerMethod(): string
    {
        $arr = explode('\\', $this->currentHandler);
        $class = array_pop($arr);
        return "{$class}::{$this->currentMethod}";
    }

    private function getUrl(): array
    {
        $url = [];
        if (!empty($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
        }
        return $url;
    }
}
