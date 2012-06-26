<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route;
use Nette\Application\Routers\CliRouter;

// Load Nette Framework
require LIBS_DIR . '/Nette/loader.php';


// Configure application
$configurator = new Nette\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
//$configurator->setDebugMode($configurator::AUTO);
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon');
$container = $configurator->createContainer();

// Setup router
if( $container->params[ 'consoleMode' ] ) {
	$container->router[] = new CliRouter();
} else {
	$container->router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
	$container->router[] = new Route('workers/<presenter>/<action>', array( 'module' => 'Workers' ) );
	$container->router[] = new Route('api/<presenter>/<action>', array( 'module' => 'Api' ) );
	$container->router[] = new Route('<presenter>/<action>[/<id>]', 'Experiments:list');
}

// Configure and run the application!
$container->application->run();
