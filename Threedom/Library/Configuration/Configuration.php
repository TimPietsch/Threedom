<?php
namespace Threedom\Library\Configuration;

/**
 * Provides functionality for configuration classes
 *
 * @deprecated
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
        $settings = $this->_list($settings);
        
        // Set defaults
        $defaults = $this->_list($this->_defaults);
        
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
     * Create list from multidimensional array
     * 
     * @access private
     * @param array $settings
     * @return array The list
     */
    private function _list($settings) {
        $list = array();
        
        foreach ((array)$settings as $name => $setting) {
            if (is_array($setting)) {
                $subsettings = $this->_list($setting);
                
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
