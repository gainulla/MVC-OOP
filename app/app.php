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

$deps = [];

switch ($route->handlerClass())
{
	###############################################################
	case 'HomeHandler':

		if ($route->handlerMethod() == 'index') {
			$deps = [];
		}
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
            // do nothing
}

$url = $container->getUrlManager();
$session = $container->getSessionManager();
$user = $container->getRepositoryR(UserR::class)->find($session->get('id'));
$renderer = $container->getRenderer($user, $url);

$route->execute($renderer, $session, $user, $url, $deps);
