<?php
namespace Threedom\Library\General;

/**
 * Provides functionality for configuration classes
 * 
 * Can be extended to provide access to system-wide and case-
 * specific configurations
 *
 * @author TimPietsch
 */
class Configuration {
    
    /* PUBLIC */
    
    final public function getConfig($configKey = null) {
        if ($configKey === null) {
            $configKey = get_class($this);
        }
        echo "## $configKey: ";
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
        
        // Save values
        if (!array_key_exists(get_class($this), self::$_settings)) {
            self::$_settings[get_class($this)] = $config;
        }
        else {
            self::$_settings[get_class($this)] = array_replace_recursive(self::$_settings[get_class($this)], $config);
        }
    }
    
    /* PRIVATE */
    
    /**
     * behaves incorrectly, maybe switch back to abstract class? meh...
     */
    private static $_settings = array();
}
