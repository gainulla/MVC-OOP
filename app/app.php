<?php

use App\Core\Route;
use App\Core\Container;
use App\Core\Database;
use App\Core\Connection;
use App\Models\UserModel;
use App\Repository\UserR;
use App\Repository\UserCUD;

$config = require(realpath(__DIR__ . '/config.php'));

$db = new Database(Connection::getInstance($config['db']));

$container = new Container($config, $db);
$route = new Route();

switch ($route->handlerMethod())
{
	case 'HomeHandler::index':
				$deps = [];
				break;
    case 'AuthHandler::login':
				$deps[] = $container->getForm(UserModel::formLabels());
				break;
	case 'AuthHandler::loginForm':
				$deps[] = $container->getRepositoryR(UserR::class);
				$deps[] = $container->getForm(UserModel::formLabels());
				break;

	case 'AuthHandler::register':
				$deps[] = $container->getForm(UserModel::formLabels());
				break;
	case 'AuthHandler::registerForm':
				$deps[] = $container->getRepositoryR(UserR::class);
				$deps[] = $container->getRepositoryCUD(UserCUD::class);
				$deps[] = $container->getForm(UserModel::formLabels());
				break;
	case 'PasswordHandler::index':
				$deps[] = $container->getForm(UserModel::formLabels());
				break;
	case 'PasswordHandler::resetForm':
				$deps[] = $container->getToken();
				$deps[] = $container->getRepositoryR(UserR::class);
				$deps[] = $container->getRepositoryCUD(UserCUD::class);
				$deps[] = $container->getForm(UserModel::formLabels());
				$deps[] = $container->getMailer();
				break;
    default:
            $deps = [];
}

$url = $container->getUrlManager();
$session = $container->getSessionManager();
$user = $container->getRepositoryR(UserR::class)->find($session->get('id'));
$renderer = $container->getRenderer($user, $url);

$route->execute($renderer, $session, $user, $url, $deps);
