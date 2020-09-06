<?php

/**
 * Application configuration shared by all test types
 */
return [
	'id' => 'teryt-tests',
	'basePath' => dirname(__DIR__),
	'bootstrap' => [
		'teryt',
	],
	'aliases' => [
		'@tests' => '@app/tests',
	],
	'language' => 'en-US',
	'controllerMap' => [
		'migrate' => [
			'class' => 'yii\console\controllers\MigrateController',
			'migrationPath' => '@app/src/migrations',
		],
	],
	'modules' => [
		'teryt' => [
			'class' => 'edzima\teryt\Module',
		],
	],
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=127.0.0.1;dbname=vestra_dev',
			'username' => 'root',
			'password' => '213joidjasoej',
			'charset' => 'utf8',
		],
		'location' => [
			'class' => 'edzima\teryt\components\Location',
		],
	],
];
