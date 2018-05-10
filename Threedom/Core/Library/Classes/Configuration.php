<?php

namespace Threedom\Core\Library\Classes;

/**
 * Provides functionality for configuration classes
 * 
 * Every instance of extended classes remembers configuration of last setConfig() call
 */
class Configuration {

    /**
     * @todo documentation
     */
    protected static function defaultConfig() {
        
    }

    /**
     * @todo documentation
     */
    final protected static function getConfig() {
        return self::$_settings[static::class];
    }

    /**
     * Defines the provided settings as constants
     * 
     * @access protected
     * @static
     * @uses $this->defaultConfig() Writes default values where no overrides are given
     * @param array $config
     * @return bool <b>TRUE</b> on success, <b>FALSE</b> if config was already set
     */
    final protected static function setConfig($config, $forceOverride = false) {
        // Save values
        if (!array_key_exists(static::class, self::$_settings)) {
            // Combine default values and overriding user settings
            $config = array_replace_recursive(static::defaultConfig(), $config);

            self::$_settings[static::class] = $config;
            return true;
        } elseif ($forceOverride) {
            // Override saved settings with provided ones
            self::$_settings[static::class] = array_replace_recursive(self::$_settings[static::class], $config);
            return true;
        } else {
            return false;
        }
    }

    private static $_settings = array();

}
