<?php

namespace App\Core;

use App\Core\TwigTemplate;
use App\Core\Url;

class Renderer
{
    private $templateEngine;
    private $menuReader;
    private $url;
    private $key;

    public function __construct(
        TwigTemplate $templateEngine,
        MenuReader $menuReader,
        Url $url,
        array $key
    ) {
        $this->templateEngine = $templateEngine;
        $this->url = $url;
        $this->menuReader = $menuReader;
        $this->key = $key;
    }

    public function render(string $template, array $data=[]): void
    {
        $data = array_merge($data, [
            'menuReader' => $this->menuReader,
            'url'  => $this->url,
            'key'  => $this->key,
        ]);

        $this->templateEngine->template($template, $data);
    }
}
