<?php

// Display errors for debugging
ini_set('display_errors', 0);

// Set internal character encoding to UTF-8
mb_internal_encoding('UTF-8');

// Set root directory
$root = __DIR__;

// Set include path
set_include_path($root);

// Set autoloader
require_once 'Threedom/Core/Autoload.php';
spl_autoload_register(new Threedom\Core\Autoload());

// Read configuration
$config = new Threedom\Core\Configuration(include 'config.php');
$config->setRoot($root);

echo "<pre>";
$cfg = $config->getConfig();
var_dump($cfg);
$cfg = $config->getConfig("system");
var_dump($cfg);
$cfg = $config->getConfig("Threedom\Core\Configuration");
var_dump($cfg);
echo "</pre>";

// Register directives
//$directives = new Threedom\Core\Directives\Manager();
//    include 'directives.php';

// Run query URL
//$directives->run();

