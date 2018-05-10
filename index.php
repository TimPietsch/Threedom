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
require_once 'Threedom/Core/Classes/Autoload.php';
spl_autoload_register(new Threedom\Core\Classes\Autoload());

// Set up core configuration
$config = new Threedom\Core\Classes\Configuration(include 'config.php');
$config::setRoot($root);

// Start viewport manager
$manager = new Threedom\Core\Classes\ViewportManager($config->getViewportId());
$manager->answer($_GET);
