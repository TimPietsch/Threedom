<?php
namespace Threedom\Library\Configuration;

/**
 * Provides functionality for configuration classes
 *
 * @todo Remove deprecated settings
 * @author Beef
 */
abstract class Configuration {
    
    /* PROTECTED */
    
    protected function setRoot($path) {
        $this->_defaults['system']['root'] = (string)$path;
    }
    
    /**
     * Defines the provided settings as constants
     * 
     * @param array $settings
     */
    protected function write($settings) {
        $settings = $this->_array_flatten($settings);
        
        // Set defaults
        $defaults = $this->_array_flatten($this->_defaults);
        
        // List settings in one-dimensional array
        $config = array_merge($defaults, $settings);
        
        foreach ($config as $name => $value) {
            define($name, $value);
        }
    }
    
    /* PRIVATE */
    
    /**
     * @access private
     * @var array Default values for the system
     */
    private $_defaults = array(
        'system' => array(
            'timestamp' => 'Y-m-d H:i:s' // deprecated?
        ),
        'project' => array(
            'name'      => 'PROJECT_NAME',
            'url'       => 'tbws.selfhost.bz',
            'autoapi'   => true
        ),
        'admin' => array(
            'name'      => 'Administration',
            'directive' => 'Admin'
        ),
        'database' => array(
            'host'      => 'localhost',
            'user'      => 'DB_USER',
            'pass'      => 'DB_PASS',
            'name'      => 'DB_NAME',
            'pref'      => 'THREEDOM'
        )
    );
    
    /**
     * Flatten a multidimensional array
     * 
     * @deprecated
     * @access private
     * @param array $array
     * @return array The one-dimensional, flat array
     */
    private function _array_flatten($array) {
        $list = array();
        
        foreach ((array)$array as $name => $setting) {
            if (is_array($setting)) {
                $subsettings = $this->_array_flatten($setting);
                
                foreach($subsettings as $key => $value) {
                    $list[strtoupper($name.'_'.$key)] = $value;
                }
            }
            else {
                $list[strtoupper($name)] = $setting;
            }
        }
        
        return $list;
    }
    
}
