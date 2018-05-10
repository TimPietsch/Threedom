<?php

namespace Threedom\Core\Classes;

use Threedom\Core\Library;

/**
 * Manages the configuration of Threedom\Core
 */
class Configuration extends Library\Classes\Configuration {

    public function __construct($config = null) {
        if ($config != null) {
            self::setConfig($config);
        }

        self::$_settings = self::getConfig();
    }

    public function setRoot($path) {
        // Set root if it was not set before
        if (!array_key_exists('root', self::$_settings['project'])) {
            $root = [
                'project' => [
                    'root' => (string)$path
                ]
            ];

            self::setConfig($root, true);

            // Update static copy of settings
            self::$_settings = self::getConfig();
        }
    }

    public static function getAppId() {
        return self::$_settings['project']['directory'];
    }

    public static function getAppDir() {
        return self::$_settings['project']['root'].'/'.self::$_settings['project']['directory'];
    }

    public static function getViewportId() {
        return self::$_settings['project']['viewport'];
    }

    public static function getViewportDir() {
        return self::$_settings['project']['root'].'/'.self::$_settings['project']['viewport'];
//        return 'Threedom/Viewports/'.self::$_settings['project']['viewport'];
    }

    protected static function defaultConfig() {
        return self::$_defaults;
    }

    /* PRIVATE */

    /**
     * @todo documentation
     */
    private static $_settings;

    /**
     * @access private
     * @var array Default values for the system
     */
    private static $_defaults = [
        'project' => [
            'name' => 'PROJECT_NAME',
            'directory' => 'Application',
            'url' => 'PROJECT_URL',
            'viewport' => 'Threedom'
        ],
        'admin' => [
            'username' => 'admin',
            'password' => 'admin'
        ],
        'database' => [
            'host' => 'localhost',
            'username' => 'DB_USER',
            'password' => 'DB_PASS',
            'name' => 'DB_NAME',
            'prefix' => 'THREEDOM'
        ]
    ];

}
