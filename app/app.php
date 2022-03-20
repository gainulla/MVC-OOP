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
    default:
            $deps = [];
}

$route->execute(
	$container->getRenderer(),
	$container->getSessionManager(),
	$deps
);
