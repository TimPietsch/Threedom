<?php
namespace Threedom\Core\Directives;

use \Threedom\Library\General;

/**
 * Handles the directives that may be executed by the system
 * 
 * @todo move to proper place in threedom structure
 * @author Beef
 */
class Manager {
    
    use General\DataAccess;
    
    /* PUBLIC */
    
    /**
     * Registers a directive to be run if the query is empty
     * 
     * @todo remove need for naming convention
     * @param string $name The name of a directive
     */
    public function standard($name) {
        // Create directive from name
        $class = '\Directives\\'.ucfirst($name).'Directive';
        
        // Save directive
        $this->_standard = $class;
    }
    
    /**
     * Registers a directive to be run under certain conditions
     * 
     * @todo remove need for naming convention
     * @param mixed $trigger What triggers the directive to run
     * @param string $name The name of a directive
     */
    public function register($trigger, $name) {
        // Create directive from name
        $class = '\Directives\\'.ucfirst($name).'Directive';
        
        // Save directive with trigger
        $this->_directives[] = array(
            'trigger' => (string)$trigger,
            'class'   => $class
        );
    }
    
    /**
     * @todo documentation
     * @param type $trigger
     */
    public function admin($trigger) {
        // Save trigger, directive is defined in core
        $words = explode(' ',(string)$trigger);
        $this->_admin = $words[0];
    }
    
    /**
     * Run the directive that best matches the current query
     * 
     * @todo AutoAPI
     */
    public function run() {
        // Input
        $get = $this->getInput('get');
        
        // Set standard directive
        $class = $this->_standard;
        // Try running AutoApi
        if (PROJECT_AUTOAPI && $get->hasParameter()){
            $class = '';
        }
        // Check directives
        foreach ($this->_directives as $directive) {
            $class = $this->_match($directive['trigger'], $get) ? $directive['class'] : $class;
        }
        // Check for admin directive
        if ($get->hasParameter($this->_admin)) {
            $class = 'Threedom\Core\Directives\AdminDirective';
        }
        
        if ($class === '') { echo __FILE__.':'.__LINE__."\n"; } // go to line 70
        
        // Run directive
        $directive = new $class();
        echo $directive();
    }
    
    /* PRIVATE */
    
    private $_admin      = ADMIN_DIRECTIVE;
    private $_standard   = 'Threedom\Core\Directives\AdminDirective';
    private $_directives = array();
    
    private function _match($trigger, General\Input $get) {
        if (is_array($trigger)) {
            $match = true;
            foreach ($trigger as $parameter) {
                $match = $get->hasParameter($parameter) ? $match : false;
            }
        }
        else {
            $match = $get->hasParameter($trigger);
        }
        
        return $match;
    }
}
