<?php
namespace Threedom\Core\Routines;

/**
 * Description of Autoload
 *
 * @author TimPietsch <TimPietsch@GitHub.com>
 */
class Autoload {
    function __invoke($objectName) {
        $path = str_replace('\\', '/', $objectName);
        
        include "$path.php";
    }
}
