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
require_once 'Threedom/Core/Routines/AutoloadOld.php';

// Read configuration
$config = new Threedom\Library\Configuration\Ini($root, 'config.ini');

// Check if the application has been deployed
$file = end(explode('\\', __FILE__));
if ($file !== 'index.php') {
    echo $file;
}

/* v to be changed v */

// Register directives
$directives = new Threedom\Core\Directives\Manager();
include 'directives.php';

// Run query URL
$directives->run();
