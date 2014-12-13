<?php

/** @var Composer\Autoload\ClassLoader $classLoader */
$classLoader = include_once __DIR__ . '/../../vendor/autoload.php';
$classLoader->addPsr4('ApiGenTests\\', __DIR__);


date_default_timezone_set('Europe/Prague');
Tester\Environment::setup();


define('TEMP_DIR', createTempDir());
Tracy\Debugger::$logDirectory = TEMP_DIR;


define('PROJECT_DIR', __DIR__ . '/../Project');
define('PROJECT_BETA_DIR', __DIR__ . '/../ProjectBeta');
define('API_DIR', TEMP_DIR . '/api');
define('APIGEN_BIN', 'php ' . realpath(__DIR__ . '/../../src/apigen.php'));


/** @return string */
function createTempDir() {
	@mkdir(__DIR__ . '/../tmp'); // @ - directory may exists
	@mkdir($tempDir = __DIR__ . '/../tmp/' . (isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid()));
	Tester\Helpers::purge($tempDir);
	return realpath($tempDir);
}


/** @return Nette\DI\Container */
function createContainer() {
	$configurator = new Nette\Configurator();
	$configurator->setDebugMode( ! \Tracy\Debugger::$productionMode);
	$configurator->setTempDirectory(TEMP_DIR);
	$configurator->addConfig(__DIR__ . '/config.neon');
	return $configurator->createContainer();
}
