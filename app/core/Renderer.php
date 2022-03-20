<?php

namespace App\Core;

use App\Core\TwigTemplate;
use App\Core\Source;

class Renderer
{
    private $templateEngine;
    private $source;
    private $key;

    public function __construct(TwigTemplate $templateEngine, Source $source, $key) {
        $this->templateEngine = $templateEngine;
        $this->source = $source;
        $this->key = $key;
    }

    public function render(string $template, array $data=[]): void
    {
        $data = array_merge($data, [
            'source'  => $this->source,
            'key'     => $this->key
        ]);

        $this->templateEngine->template($template, $data);
    }
}
