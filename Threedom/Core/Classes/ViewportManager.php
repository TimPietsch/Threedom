<?php

namespace Threedom\Core\Classes;

use \Threedom\Library\General;

/**
 * Handles the directives that may be executed by the system
 * 
 * @todo documentation
 */
class ViewportManager {

    /**
     * @todo proper error management
     */
    public function __construct($viewport) {

        // Set Viewports directory
        $parentDir = 'Threedom/Viewports';

        // Check if viewport is installed
        $viewportDir = $parentDir.'/'.$viewport;
        if (is_dir($viewportDir)) {
            $viewportClass = str_replace('/', '\\', $viewportDir).'\Viewport';
            $this->_viewport = new $viewportClass();
        } else {
            
        }
    }

    /**
     * @todo documentation
     */
    public function answer($get) {

        $viewport = $this->_viewport;

        if (empty($get)) {
            echo (string)$viewport;
        } else {
            $action = $viewport($get);
            echo (string)$action;
        }
    }

    /**
     * Registers a directive to be run if the query is empty
     * 
     * @deprecated
     * @param string $name The name of a directive
     */
    public function standard($name) {
        // Create directive from name
        $class = '\Actions\\'.ucfirst($name);

        // Save directive
        $this->_standard = $class;
    }

    /**
     * Registers a directive to be run under certain conditions
     * 
     * @deprecated
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
            'class' => $class
        );
    }

    /**
     * Run the directive that best matches the current query
     * 
     * @deprecated
     */
    public function run() {
        // Input
        $get = $this->getInput('get');

        // Set standard directive
        $class = $this->_standard;
        // Try running AutoApi
        if (PROJECT_AUTOAPI && $get->hasParameter()) {
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

        if ($class === '') {
            echo __FILE__.':'.__LINE__."\n";
        } // go to line 70
        // Run directive
        $directive = new $class();
        echo $directive();
    }

    private $_viewport;
    private $_standard = 'Threedom\Core\Directives\AdminDirective';
    private $_directives = array();

    /**
     * @deprecated
     */
    private function _match($trigger, General\Input $get) {
        if (is_array($trigger)) {
            $match = true;
            foreach ($trigger as $parameter) {
                $match = $get->hasParameter($parameter) ? $match : false;
            }
        } else {
            $match = $get->hasParameter($trigger);
        }

        return $match;
    }

}
