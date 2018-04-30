<?php
namespace Threedom\Core;

use Threedom\Library\General;

/**
 * Provides functionality for configuration classes
 *
 * @todo Remove deprecated settings
 */
class Configuration extends General\Configuration {
    
    /* PUBLIC */
    
    public function __construct($config) {
        $this->setConfig($config);
    }
    
    public function setRoot($path) {
        $this->setConfig([
            'system' => [
                'root' => (string)$path
            ]
        ]);
    }
    
    /* PROTECTED */
    
    protected function defaultConfig() {
        return $this->_defaults;
    }
    
    /* PRIVATE */
    
    /**
     * @access private
     * @var array Default values for the system
     */
    private $_defaults = [
        'system' => [
            'timestamp' => 'Y-m-d H:i:s' // deprecated?
        ],
        'project' => [
            'name'      => 'PROJECT_NAME',
            'url'       => 'PROJECT_URL',
            'autoapi'   => true
        ],
        'admin' => [
            'name'      => 'Administrator',
            'directive' => 'Admin'
        ],
        'database' => [
            'host'      => 'localhost',
            'username'  => 'DB_USER',
            'password'  => 'DB_PASS',
            'name'      => 'DB_NAME',
            'prefix'    => 'THREEDOM'
        ]
    ];
    
}
