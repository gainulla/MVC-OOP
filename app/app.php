<?php

use App\Core\Route;
use App\Core\Container;
use App\Core\Database;
use App\Core\Connection;
use App\Core\Auth;
use App\Models\UserModel;
use App\Repository\UserR;
use App\Repository\UserCUD;

$config = require(realpath(__DIR__ . '/config.php'));

$db = new Database(Connection::getInstance($config['db']));

$container = new Container($config, $db);
$route = new Route();

$deps = [];

switch ($route->handlerClass())
{
	###############################################################
	case 'HomeHandler':
		break;

	###############################################################
	case 'AuthHandler':

		if ($route->handlerMethod() == 'register') {
			$deps[] = $container->getForm(UserModel::formLabels());
		}
		elseif ($route->handlerMethod() == 'login') {
			$deps[] = $container->getForm(UserModel::formLabels());
		}
		elseif ($route->handlerMethod() == 'loginForm') {
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getForm(UserModel::formLabels());
		}
		elseif ($route->handlerMethod() == 'registerForm') {
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getRepositoryCUD(UserCUD::class);
			$deps[] = $container->getForm(UserModel::formLabels());
		}
		break;

	###############################################################
	case 'PasswordResetHandler':

		if ($route->handlerMethod() == 'index') {
			$deps[] = $container->getForm(UserModel::formLabels());
		}
		elseif ($route->handlerMethod() == 'emailForm') {
			$deps[] = $container->getToken();
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getRepositoryCUD(UserCUD::class);
			$deps[] = $container->getForm(UserModel::formLabels());
			$deps[] = $container->getMailer();
		}
		elseif ($route->handlerMethod() == 'reset') {
			$deps[] = $container->getToken();
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getRepositoryCUD(UserCUD::class);
			$deps[] = $container->getForm(UserModel::formLabels());
		}
		elseif ($route->handlerMethod() == 'resetForm') {
			$deps[] = $container->getToken();
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getRepositoryCUD(UserCUD::class);
			$deps[] = $container->getForm(UserModel::formLabels());
		}
		break;

	################################################################
    default:
			break;
}

$session = $container->getSessionManager();

$auth = new Auth();

if ($session->has('logged_in_user')) {
	$auth->authenticate(
		$container
			->getRepositoryR(UserR::class)
			->find($session->get('logged_in_user'))
	);
}

$url = $container->getUrlManager();
$renderer = $container->getRenderer($auth, $url);

$route->execute($renderer, $session, $auth, $url, $deps);
