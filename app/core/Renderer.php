<?php

namespace App\Core;

use App\Core\TwigTemplate;
use App\Core\Url;
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
        Url $url,
        array $key,
        UserModel $user
    ) {
        $this->templateEngine = $templateEngine;
        $this->menuReader = $menuReader;
        $this->url = $url;
        $this->key = $key;
        $this->user = $user;
    }

    public function render(string $template, array $data=[]): void
    {
        $data = array_merge($data, [
            'menuReader' => $this->menuReader,
            'url'  => $this->url,
            'key'  => $this->key,
            'user' => $this->user
        ]);

        $this->templateEngine->template($template, $data);
    }
}
