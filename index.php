<?php

// Display errors for debugging
ini_set('display_errors', 1);

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

if (count($_GET) !== 0) {
    // Send POST data to module
}
else {
    // Register directives
    $directives = new Threedom\Core\Directives\Manager();
//    include 'directives.php';

    // Run query URL
    $directives->run();
}
