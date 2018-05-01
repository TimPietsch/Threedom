<?php

namespace Threedom\Library\General;

/**
 * Provides functionality for configuration classes
 * 
 * Every instance of extended classes remembers configuration of last setConfig() call
 */
class Configuration {

    /**
     * @todo documentation
     */
    final protected function getConfig() {
        return self::$_settings[get_class($this)];
    }

    /**
     * @todo documentation
     */
    protected function defaultConfig() {
        
    }

    /**
     * Defines the provided settings as constants
     * 
     * @access protected
     * @uses $this->defaultConfig() Writes default values where no overrides are given
     * @param array $config
     * @return bool <b>TRUE</b> on success, <b>FALSE</b> if config was already set
     */
    final protected function setConfig($config, $forceOverride = false) {
        // Save values
        if (!array_key_exists(get_class($this), self::$_settings)) {
            // Combine default values and overriding user settings
            $config = array_replace_recursive($this->defaultConfig(), $config);

            self::$_settings[get_class($this)] = $config;
            return true;
        } elseif ($forceOverride) {
            self::$_settings[get_class($this)] = array_replace_recursive(self::$_settings[get_class($this)], $config);
            return true;
        } else {
            return false;
        }
    }

    /* PRIVATE */

    /**
     * behaves incorrectly, maybe switch back to abstract class? meh...
     */
    private static $_settings = array();

}
