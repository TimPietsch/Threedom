<?php

namespace Threedom\Core\Classes;

use Threedom\Core\Library;

/**
 * Manages the configuration of Threedom\Core
 */
class Configuration extends Library\Classes\Configuration {

    public function __construct($config = null) {
        if ($config != null) {
            $this->setConfig($config);
        }

        $this->_settings = $this->getConfig();
    }

    public function setRoot($path) {
        // Set root if it was not set before
        if (!array_key_exists('root', $this->_settings['project'])) {
            $root = [
                'project' => [
                    'root' => (string)$path
                ]
            ];

            $this->setConfig($root, true);
        }
    }

    public function getAppDir() {
        return $this->_settings['project']['root'].'/'.$this->_settings['project']['directory'];
    }

    public function getViewport() {
        return $this->_settings['project']['viewport'];
    }

    /* PROTECTED */

    protected function defaultConfig() {
        return $this->_defaults;
    }

    /* PRIVATE */

    /**
     * @todo documentation
     */
    private $_settings;

    /**
     * @access private
     * @var array Default values for the system
     */
    private $_defaults = [
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
