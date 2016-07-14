<?php

// Display errors for debugging
ini_set('display_errors', 1);

// Set internal character encoding to UTF-8
mb_internal_encoding('UTF-8');

// Set autoloader
$root = __DIR__;
require_once $root.'/Threedom/Core/Routines/Autoload.php';

// Read configuration
$config = new Threedom\Configuration\Ini($root, 'config.ini');

// Register directives
$directives = new Threedom\Core\Directives\Manager();
include 'directives.php';

// Run query URL
$directives->run();
