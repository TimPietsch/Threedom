<?php
namespace Threedom\Core;

/**
 * Description of Autoload
 *
 * @todo Remove access to global variable
 * @author TimPietsch <TimPietsch@GitHub.com>
 */
class Autoload {
    function __invoke($objectName) {
        global $root;
        $path = str_replace('\\', '/', $objectName);
        
        // Include file from application
        if (file_exists("$root/$path.php")) {
            include "$root/$path.php";
        }
        // Include file from standard include path
        else {
            include "$path.php";
        }
    }
}
