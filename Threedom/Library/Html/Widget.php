<?php
namespace Threedom\Library\Html;

use \Threedom\Library\General;

/**
 * Provides a framework to add HTML elements to the returned document
 * 
 * @todo interface documentation
 * @author Beef
 */
class Widget implements Interfaces\iWidget {
    
    use General\DataAccess;
    
    /* PUBLIC */
    
    /**
     * @todo Documentation
     */
    public final function __construct($template = null, Context $current = null) {
        // Provide GET and POST information
        $this->input['get']  = new General\Input('get');
        $this->input['post'] = new General\Input('post');
        
        // Set default HTML context
        $this->_context = new Context();
        
        // Open template
        if ($template === null) {
            $template = 'Templates/'.ucfirst(end(explode('\\', get_class($this))));
        }
        $this->setTemplate($template);
        
        // Override with child class settings
        $this->setup((string)$template);
        
        // Retrieve child data
        $this->_data = $this->getData();
        
        if (get_class($this) === 'Threedom\Core\Modules\Backend') {
//            var_dump($this->_data);
        }
        
        // Prepare elements in the template
        $this->_template = $this->_tdRepeat($this->_template);
        $this->_template = $this->_tdWidget($this->_template);
        
        // Current context overrides defaults of child class
        if ($current !== null) {
            $this->_context->update($current);
        }
        
        // Encase template in tags
        $this->_template = $this->_context->encase($this->_template);
    }
    
    /**
     * Returns the registered styles for this widget
     * 
     * @final
     * @return array The registered styles
     */
    public final function getStyles() {
        return $this->_styles;
    }
    
    /**
     * Returns the registered scripts for this widget
     * 
     * @final
     * @return array The registered scripts
     */
    public final function getScripts() {
        return $this->_scripts;
    }
    
    public final function __toString() {
        // Bind data to template
        $filled = $this->_fill($this->_template, $this->_data);
        
        return $filled;
    }
    
    /* PROTECTED */
    
    protected $input = array();
    
    /**
     * Is run on object initialization
     * 
     * Important configuration goes here
     * 
     * @access protected
     */
    protected function setup() {}
    
    /**
     * Is run on output
     * 
     * Should return a data set as an array.
     * 
     * @access protected
     * @return array The data the template should be filled with
     */
    protected function getData() {}
    
    /**
     * Configures the default HTML context of the widget
     * 
     * The indexed values of the array are interpreted as special settings:
     * <i>0</i> - The HTML tag
     * 
     * The associative values are included in the HTML element containing the
     * widget as element attributes.
     * 
     * @todo update documentation
     * @access protected
     * @param \Threedom\Modules\Html\Context $context The new context
     */
    protected final function setContext(Context $context) {
        $this->_context->update($context);
    }
    
    /**
     * Sets the template that should be used
     * 
     * @todo Maybe support multiple templates and change to addTemplate?
     * @access protected
     * @param string $template
     */
    protected final function setTemplate($template) {
        $this->_open((string)$template);
    }
    
    /**
     * Registers a style as a dependency for this widget
     * 
     * @todo Remove file ending if provided
     * @access protected
     * @param string $name
     */
    protected final function addStyle($name) {
        // Add every style only once
        if (!in_array($name, $this->_styles)) {
            $this->_styles[] = (string)$name;
        }
    }
    
    /**
     * Registers a script as a dependency for this widget
     * 
     * @access protected
     * @param string $name
     */
    protected final function addScript($name) {
        // Add every script only once
        if (!in_array($name, $this->_scripts)) {
            $this->_scripts[] = (string)$name;
        }
    }
    
    /* PRIVATE */
    
    private $_context;
    private $_styles  = array();
    private $_scripts = array();
    private $_template;
    private $_data;
    
    /**
     * Opens the specified template, parses it and binds data
     * 
     * @access private
     * @param string $template The name of the template
     * @return string The template filled with data
     */
    private function _open($template) {
        $template = ucfirst((string)$template);
        
        // Retrieve template
        if (file_exists(stream_resolve_include_path($template.'.html'))) {
            $markup = file_get_contents($template.'.html', true);
        }
        else if (file_exists('Templates/'.$template.'.html')) {
            $markup = file_get_contents('Templates/'.$template.'.html');
        }
        else {
            $markup = 'Template nicht gefunden: '.$template.".html\n";
        }
        
        // Save template markup
        $this->_template = $markup;
    }
    
    /**
     * Binds the provided data to the given markup
     * 
     * @access private
     * @param string $markup The markup to be parsed
     * @param array $data The data as an associative array
     * @return string The filled markup
     */
    private function _fill($markup, $data) {
        // Replace remaining variables with data
        if (is_array($data)) {
            // Replace only in widgets with variables
            foreach ($data as $placeholder => $value) {
                // Loop over variables in data
                if (!is_array($value)) {
                    // Just replace simple variables
                    $markup = preg_replace('/%'.strtoupper($placeholder).'%/', (string)$value, $markup);
                }
            }
        }
        
        // Return filled widget
        return $markup;
    }
    
    /**
     * Looks for link declarations and updates them to the correct reference
     * 
     * @todo implement
     * @access protected
     * @return string The updated template
     */
    private function _tdLink() {
        
    }
    
    /**
     * Repeats element with a repeat declaration and fills them with iteration variables
     * 
     * @todo Fix for empty data, so no element is displayed
     * @access private
     * @param string $markup
     * @param array $data
     * @return string
     */
    private function _tdRepeat($markup) {
        // Repeat elements
        $repeat = array();
        if (!preg_match_all('/<([A-Za-z]\w*)[^>]*? td-repeat="([\w\-]*?)"[^>]*?>(?:(?!<\/\1>).*?)?<\/\1>/s', $markup, $repeat, PREG_SET_ORDER)) {
            return $markup;
        }
        
        foreach ($repeat as $instance) {
            // Remove repeat command before calling _tdRepeat()
            $element = preg_replace('/ td-repeat="[\w\-]*?"/s', '', $instance[0]);
            if (!is_array($this->_data[$instance[2]])) { continue; }
            
            // Actually repeat
            $repeated = '';
            foreach ($this->_data[$instance[2]] as $iteration) {
                $repeated .= $this->_fill($element, $iteration);
            }
            
            $markup = str_replace($instance[0], $repeated, $markup);
        }
        
        return $markup;
    }
    
    /**
     * Looks for child widget declarations and returns the markup with replaced widgets
     * 
     * @todo use html\context
     * @access private
     * @param string The markup
     * @return string The markup including the child widgets
     */
    private function _tdWidget($markup) {
        // Look for declaration
        return preg_replace_callback('/(<([a-z]\w*)(?: [a-z][a-z0-9-_]*="[^"]+")*? td-widget="([^"]+)"(?: [a-z][a-z0-9-_]*="[^"]+")*?>).*?<\/\2>/i', function($matches){
            // Generate namespace
            $namespace = explode('\\', get_class($this));
            array_pop($namespace); // Remove the parent class
            $namespace = implode('\\', $namespace);
            
            // Generate name and HTML context from declaration
            $name = $namespace.'\\'.ucfirst($matches[3]).'Object';
            $context = new Context($matches[1], 'td-widget');
            
            // Create object
            $child = new $name($matches[3], $context);
            
            // Register child widget needs
            foreach ($child->getStyles() as $style) {
                $this->addStyle($style);
            }
            foreach ($child->getScripts() as $script) {
                $this->addScript($script);
            }
            
            return $child;
        }, $markup);
    }
    
}
