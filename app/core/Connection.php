<?php

namespace App\Core;

use PDO;

final class Connection extends PDO
{
	private static $instance = NULL;

	private function __construct(array $settings)
	{
		$required = ['host','name','user','password','charset'];
		extract($settings);

		foreach ($required as $setting) {
			if (!isset($setting)) {
				throw new \InvalidArgumentException("The '{$setting}' is required!");
			}
		}

		$dsn = "mysql:host={$host};dbname={$name};charset={$charset}";

		parent::__construct($dsn, $user, $password);

		$this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

		if (DEV_MODE === TRUE) {
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}

	public static function getInstance(array $settings)
	{
		if (self::$instance === NULL) {
			self::$instance = new Connection($settings);
		}

		return self::$instance;
	}
}
