<?php

namespace App\Libs;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Twig\TwigFunction;

class TwigTemplate implements \App\Contracts\TemplateInterface
{
    private $templateDirPath;

    public function __construct(string $templateDirPath)
    {
        $this->templateDirPath = $templateDirPath;
    }

    public function template(string $templateFile, array $data=[]): string
    {
        $filename = "{$this->templateDirPath}/{$templateFile}.html";
        if (!file_exists($filename)) {
            throw new \Exception("File '$filename' doesn't exist.");
        }

        $loader = new FilesystemLoader($this->templateDirPath);
        $twig = new Environment($loader);
        $twig->addExtension(new DebugExtension());
        $twig->enableDebug();

        return $twig->render("{$templateFile}.html", $data);
    }
}
