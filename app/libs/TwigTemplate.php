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

    public function template(string $templateFile, array $data=[]): void
    {
        $filename = "{$this->templateDirPath}/{$templateFile}.twig";
        if (!file_exists($filename)) {
            throw new \Exception("File '$filename' doesn't exist.");
        }

        $loader = new FilesystemLoader($this->templateDirPath);
        $twig = new Environment($loader);
        $twig->addExtension(new DebugExtension());
        $twig->enableDebug();

        echo $twig->render("{$templateFile}.twig", $data);
    }
}
