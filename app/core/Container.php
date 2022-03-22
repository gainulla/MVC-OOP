<?php

namespace App\Core;

use App\Core\Connection;
use App\Core\Database;
use App\Core\Renderer;
use App\Core\TwigTemplate;
use App\Core\Form;
use App\Core\Url;
use App\Core\MenuReader;
use App\Core\SessionManager;
use App\Contracts\RInterface;
use App\Contracts\CUDInterface;
use App\Models\UserModel;

class Container
{
    private $db;
    private $config;

    public function __construct(array $config, Database $db)
    {
        $this->db = $db;
        $this->config = $config;
    }

    public function getRepositoryR(string $repoPath): RInterface
    {
        return new $repoPath($this->db);
    }

    public function getRepositoryCUD(string $repoPath): CUDInterface
    {
        return new $repoPath($this->db);
    }

    public function getForm(array $formLabels): Form
    {
        return new Form($formLabels);
    }

    public function getRenderer(UserModel $user): Renderer
    {
        return new Renderer(
            new TwigTemplate($this->config['template_path']),
            new MenuReader(),
            new Url(
                $this->config['css_dir_uri'],
                $this->config['img_dir_uri'],
                $this->config['js_dir_uri'],
            ),
            $this->config['key'],
            $user
        );
    }

    public function getSessionManager(): SessionManager
    {
        return new SessionManager();
    }
}
