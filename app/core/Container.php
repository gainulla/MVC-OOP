<?php

namespace App\Core;

use App\Core\Connection;
use App\Core\Database;
use App\Core\Renderer;
use App\Core\Form;
use App\Core\MenuReader;
use App\Core\UrlManager;
use App\Core\SessionManager;
use App\Core\Token;
use App\Core\Auth;
use App\Libs\TwigTemplate;
use App\Libs\SymfonyMailer;
use App\Contracts\RInterface;
use App\Contracts\CUDInterface;

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

    public function getUrlManager(): UrlManager
    {
        return new UrlManager(
            $this->config['assets_uri'],
            $this->config['allow_img_ext']
        );
    }

    public function getRenderer(Auth $auth, UrlManager $url): Renderer
    {
        return new Renderer(
            new TwigTemplate($this->config['template_path']),
            new MenuReader(),
            $url,
            $auth,
            $this->config['key']
        );
    }

    public function getSessionManager(): SessionManager
    {
        return new SessionManager();
    }

    public function getToken(): Token
    {
        return new Token($this->config['token_key']);
    }

    public function getMailer(): SymfonyMailer
    {
        return new SymfonyMailer($this->config['smtp'], $this->config['admin_email']);
    }
}
