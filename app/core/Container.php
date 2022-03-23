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
use App\Libs\TwigTemplate;
use App\Libs\Swiftmailer;
use App\Models\UserModel;
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
            $this->config['css_dir_uri'],
            $this->config['img_dir_uri'],
            $this->config['js_dir_uri'],
        );
    }

    public function getRenderer(UserModel $user, UrlManager $url): Renderer
    {
        return new Renderer(
            new TwigTemplate($this->config['template_path']),
            new MenuReader(),
            $url,
            $user,
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

    public function getMailer(): Swiftmailer
    {
        return new Swiftmailer($this->config['smtp'], $this->config['adminEmail']);
    }
}
