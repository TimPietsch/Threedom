<?php
spl_autoload_register(function($objectName) {
    global $root;
    $path = str_replace('\\', '/', $objectName);

    // Check if file exists before including
    if (file_exists("$root/$path.php")) {
        // Include file from central /php/ directory
        include "$root/$path.php";
    }
    else {
        include "$path.php";
    }
});