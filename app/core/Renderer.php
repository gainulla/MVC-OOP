<?php

namespace App\Core;

use App\Core\UrlManager;
use App\Libs\TwigTemplate;
use App\Models\UserModel;

class Renderer
{
    private $templateEngine;
    private $menuReader;
    private $url;
    private $user;
    private $key;

    public function __construct(
        TwigTemplate $templateEngine,
        MenuReader $menuReader,
        UrlManager $url,
        UserModel $user,
        array $key
    ) {
        $this->templateEngine = $templateEngine;
        $this->menuReader = $menuReader;
        $this->url = $url;
        $this->user = $user;
        $this->key = $key;
    }

    public function render(string $template, array $data=[]): void
    {
        $data = array_merge($data, [
            'menuReader' => $this->menuReader,
            'url'  => $this->url,
            'key'  => $this->key,
            'user' => $this->user
        ]);

        echo $this->templateEngine->template($template, $data);
    }

    public function getTemplate(string $template, array $data=[]): string
    {
        $data = array_merge($data, [
            'url'  => $this->url,
            'user' => $this->user
        ]);

        return $this->templateEngine->template($template, $data);
    }
}
