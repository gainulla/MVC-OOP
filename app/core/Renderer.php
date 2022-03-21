<?php

namespace App\Core;

use App\Core\TwigTemplate;
use App\Core\Url;

class Renderer
{
    private $templateEngine;
    private $url;
    private $key;

    public function __construct(TwigTemplate $templateEngine, Url $url, array $key) {
        $this->templateEngine = $templateEngine;
        $this->url = $url;
        $this->key = $key;
    }

    public function render(string $template, array $data=[]): void
    {
        $data = array_merge($data, [
            'url' => $this->url,
            'key' => $this->key
        ]);

        $this->templateEngine->template($template, $data);
    }
}
