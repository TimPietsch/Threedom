<?php
namespace Threedom\Library\Configuration;

/**
 * Description of Configuration
 *
 * @deprecated
 * @author Beef
 */
class Ini extends Config {
    
    public function __construct($root, $file) {
        $settings = parse_ini_file($root.'/'.$file, true);
        
        $this->setRoot($root);
        
        $this->write($settings);
    }
    
}
