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
        
        var_dump(self::$_settings);
        
        return self::$_settings[$configKey];
    }

    /* PROTECTED */

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
        $config = array_merge($this->defaultConfig(), $config);
        
        // Define values as constants
        if (!array_key_exists(get_class($this), self::$_settings)) {
            self::$_settings[get_class($this)] = $config;
        }
        
        var_dump(self::$_settings);
    }
    
    protected function defaultConfig() {}
    
    /* PRIVATE */
    
    /**
     * behaves incorrectly, maybe switch back to abstract class? meh...
     */
    private static $_settings = array();
}
