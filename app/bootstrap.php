<?php

// Load Nette Framework or autoloader generated by Composer
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../libs/extensions.php';

mb_internal_encoding( 'UTF-8' );

$configurator = new Nette\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
$configurator->setDebugMode(FALSE);
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../libs')
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon', 'production');
$container = $configurator->createContainer();

return $container;
