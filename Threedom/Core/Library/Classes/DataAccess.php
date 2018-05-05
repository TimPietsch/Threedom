<?php
namespace Threedom\Library\General;

use \Threedom\Library\Database;

/**
 * Interface for standard model interactions
 * 
 * should maybe provide a framework for loading different models ?_?
 * 
 * @todo proper documentation
 * @author TimPietsch
 */
trait DataAccess {
    
    /* PUBLIC */
    
    /* PROTECTED */
    
    /**
     * @todo documentation
     * @param type $input
     * @return type
     */
    protected function getInput($input) {
        if (!array_key_exists(strtolower($input), $this->_inputs)) {
            $this->_inputs[strtolower($input)] = new Input((string)$input);
        }
        
        return $this->_inputs[strtolower($input)];
    }
    
    /**
     * @todo documentation
     */
    protected final function setTable() {
        
    }
    
    /**
     * @todo documentation
     * @param type $name
     * @return type
     */
    protected function getTable($name) {
        if (!array_key_exists(strtolower($name), $this->_tables)) {
            $this->_tables[strtolower($name)] = new Database\Table((string)$name, 'dev');
        }
        
        return $this->_tables[strtolower($name)];
    }
    
    /* PRIVATE */
    
    private $_tables = array();
    private $_inputs = array();
    
}
