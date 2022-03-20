<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Twig\TwigFunction;

class TwigTemplate
{
    private $templateDirPath;

    public function __construct(string $templateDirPath)
    {
        $this->templateDirPath = $templateDirPath;
    }

    public function template(string $template_file, array $data=[]): void
    {
        $filename = "{$this->templateDirPath}/{$template_file}.twig";
        if (!file_exists($filename)) {
            throw new \Exception("File '$filename' doesn't exist.");
        }

        $loader = new FilesystemLoader($this->templateDirPath);
        $twig = new Environment($loader);
        $twig->addExtension(new DebugExtension());
        $twig->enableDebug();

        echo $twig->render("{$template_file}.twig", $data);
    }
}
