<?php
namespace Threedom\Library;

/**
 * Provides functionality for configuration classes
 *
 * @author TimPietsch
 */
abstract class Configuration {
    
    /* PUBLIC */
    
    /**
     * 
     * @param type $namespace
     * @deprecated
     */
    final public function __construct($namespace = null) {
        if ((string)$namespace === '') {
            echo __FILE__.':'.__LINE__;
        }
        
        $this->_namespace = (string)$namespace;
    }
    
    /**
     * Defines the provided settings as constants
     * 
     * @todo write correct error behaviour
     * @access public
     * @uses $this->defaultValues() Writes default values where no overrides are given
     * @param array $settings
     * @return bool <b>TRUE</b> on success, <b>FALSE</b> otherwise
     */
    final public function write($settings) {
        // Error on empty namespace
        $success = true;
        if ($this->_namespace === '') {
            echo __FILE__.':'.__LINE__;
            $success = false;
        }
        
        // Combine default values and overriding user settings
        $config = array_merge($this->defaultValues(), $settings);
        
        // Define values as constants
        define(get_class($this), $config);
        
        return $success;
    }
    
    /* PROTECTED */
    
    abstract protected function defaultValues();

    /* PRIVATE */
    
    /**
     * The namespace for which the configuration settings will be saved
     * 
     * @access private
     * @var string
     */
    private $_namespace;
    
}
