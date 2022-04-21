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

switch ($route->getHandler())
{
	###############################################################
	case 'HomeHandler':
		break;

	###############################################################
	case 'AuthHandler':

		if ($route->getAction() == 'register') {
			$deps[] = $container->getForm(UserModel::formFields());
		}
		elseif ($route->getAction() == 'login') {
			$deps[] = $container->getForm(UserModel::formFields());
		}
		elseif ($route->getAction() == 'loginForm') {
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getForm(UserModel::formFields());
		}
		elseif ($route->getAction() == 'registerForm') {
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getRepositoryCUD(UserCUD::class);
			$deps[] = $container->getForm(UserModel::formFields());
		}
		break;

	###############################################################
	case 'PasswordResetHandler':

		if ($route->getAction() == 'index') {
			$deps[] = $container->getForm(UserModel::formFields());
		}
		elseif ($route->getAction() == 'emailForm') {
			$deps[] = $container->getToken();
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getRepositoryCUD(UserCUD::class);
			$deps[] = $container->getForm(UserModel::formFields());
			$deps[] = $container->getMailer();
		}
		elseif ($route->getAction() == 'reset') {
			$deps[] = $container->getToken();
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getRepositoryCUD(UserCUD::class);
			$deps[] = $container->getForm(UserModel::formFields());
		}
		elseif ($route->getAction() == 'resetForm') {
			$deps[] = $container->getToken();
			$deps[] = $container->getRepositoryR(UserR::class);
			$deps[] = $container->getRepositoryCUD(UserCUD::class);
			$deps[] = $container->getForm(UserModel::formFields());
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
