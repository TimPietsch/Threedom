<?php
namespace Threedom\Library\Traits;

/**
 * Provides functionality for configuration classes
 *
 * @author TimPietsch
 */
class Configuration {
    
    /* PUBLIC */
    
    final public function getConfig($configKey = null) {
        if ($configKey === null) {
            $configKey = get_class($this);
        }
        
//        echo __FILE__.':'.__LINE__.' - ';
//        var_dump(self::$_settings[$configKey]);
        
        return self::$_settings[$configKey];
    }

    /* PROTECTED */
    
    protected function defaultConfig() {}
    
    /**
     * Defines the provided settings as constants
     * 
     * @access protected
     * @uses $this->defaultConfig() Writes default values where no overrides are given
     * @param array $config
     * @return bool <b>TRUE</b> on success, <b>FALSE</b> otherwise
     */
    final protected function setConfig($config) {
        // Combine default values and overriding user settings
        $config = array_replace_recursive($this->defaultConfig(), $config);
//        echo __FILE__.':'.__LINE__."\n";
        
        // Save values
        if (!array_key_exists(get_class($this), self::$_settings)) {
            self::$_settings[get_class($this)] = $config;
//            echo __FILE__.':'.__LINE__."\n";
//            echo 'create - ';
//            var_dump(self::$_settings);
        }
        else {
//            echo __FILE__.':'.__LINE__."\n";
//            echo 'before - ';
//            var_dump(self::$_settings);
//            echo 'new - ';
//            var_dump($config);
            self::$_settings[get_class($this)] = array_replace_recursive(self::$_settings[get_class($this)], $config);
        }
        
//        echo __FILE__.':'.__LINE__."\n";
//        echo 'after - ';
//        var_dump(self::$_settings);
    }
    
    /* PRIVATE */
    
    /**
     * behaves incorrectly, maybe switch back to abstract class? meh...
     */
    private static $_settings = array();
}
