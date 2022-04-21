<?php

namespace App\Core;

use App\Core\Renderer;
use App\Core\UrlManager;
use App\Core\SessionManager;
use App\Core\Auth;

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

        $class = sprintf(
            "\App\Handlers\%sHandler",
            $this->convertToCamelCase($url[0], true)
        );

        if (class_exists($class)) {
            $this->currentHandler = $class;
            unset($url[0]);
        }

        if (isset($url[1])) {
            $method = $this->convertToCamelCase($url[1]);

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
        Auth $authUser,
        UrlManager $url,
        $dependencies = []): void
    {
        call_user_func_array(
            [
                new $this->currentHandler(
                    $renderer,
                    $session,
                    $authUser,
                    $url,
                    $this->params
                ),
                $this->currentMethod
            ],
            $dependencies
        );
    }

    public function getHandler(): string
    {
        $arr = explode('\\', $this->currentHandler);
        return array_pop($arr);
    }

    public function getAction(): string
    {
        return $this->currentMethod;
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

    private function convertToCamelCase($string, $firstIsUppercase=false)
    {
        if (strpos($string, '-') !== false) {
            $explode = explode('-', $string);
            $string = "";

            foreach ($explode as $x => $part) {
                if (!$firstIsUppercase) {
                    $string .= ($x == 0) ? $part : ucfirst($part);
                } else {
                    $string .= ucfirst($part);
                }
            }
        } else {
            $string = $firstIsUppercase ? ucfirst($string) : $string;
        }

        return $string;
    }
}
