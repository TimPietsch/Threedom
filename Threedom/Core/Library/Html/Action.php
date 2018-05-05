<?php
namespace Threedom\Library\Html;

use \Threedom\Library\General;

/**
 * A directive for creating HTML documents
 * 
 * @abstract
 * @author Beef
 */
abstract class Action extends General\Action {
    
    /* PROTECTED */
    
    /**
     * Adds a model to the HTML document
     * 
     * @todo update documentation
     * @access protected
     * @param string $name
     * @param string $widget
     */
    protected final function addWidget(Widget $widget) {
        // Add object to the list
        $this->_widgetsList[] = $widget;

        // Registered styles and scripts are dependent on object
        if ($widget instanceof Interfaces\iWidget) {
            $this->_registerStyles($widget->getStyles());
            $this->_registerScripts($widget->getScripts());
        }
    }
    
    /**
     * 
     * @deprecated maybe?
     * @todo documentation
     * @param type $style
     */
    protected final function addStyle($style) {
        $this->_registerStyles(array($style));
    }
    
    protected final function run() {
        return <<<END_OF_DOCUMENT
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    {$this->_printTitle()}
    {$this->_printStyles()}
    {$this->_printScripts()}
</head>
<body>
    {$this->_printTemplates()}
</body>
</html>
END_OF_DOCUMENT;
    }
    
    /* PRIVATE */
    
    /**
     * A list of all title parts to be included in the document's title
     * 
     * @access private
     * @var array The document's title parts
     */
    private $_titleParts = array(
        PROJECT_NAME
    );
    
    /**
     * A list of all successfully registered styles
     * 
     * @access private
     * @var array
     */
    private $_stylesList = array();
    
    /**
     * A list of all successfully registered scripts
     * 
     * @access private
     * @var array
     */
    private $_scriptsList = array();
    
    /**
     * A list of all successfully registered widgets
     * 
     * @access private
     * @var array
     */
    private $_widgetsList = array();
    
    /**
     * Returns an HTML title tag, composed from the registered parts
     * 
     * @access private
     * @return string
     */
    private function _printTitle() {
        return '<title>'.implode(' | ', $this->_titleParts).'</title>';
    }
    
    /**
     * Returns all registered styles as HTML tags
     * 
     * @access private
     * @return string
     */
    private function _printStyles() {
        // Reset
        $reset = "<style>\n".file_get_contents('Threedom/Core/Styles/Reset.css', true)."\n</style>";
        
        // Loop over styles
        $styles = array();
        foreach ($this->_stylesList as $style) {
            if (strpos($style, 'td-') === 0 && file_exists(stream_resolve_include_path('Threedom/Core/Styles/'.$style.'.css'))) {
                $styles[] = '<style>'.file_get_contents('Threedom/Core/Styles/'.$style.'.css', true).'</style>';
            }
            else if (file_exists('Styles/'.ucfirst($style).'.css')) {
                $styles[] = '<link rel="stylesheet" href="Styles/'.ucfirst($style).'.css">';
            }
        }
        
        return $reset.implode("\n", $styles);
    }
    
    /**
     * Returns all registered scripts as HTML tags
     * 
     * @access private
     * @return string
     */
    private function _printScripts() {
        $scripts = array();
        
        // Loop over scripts
        foreach ($this->_scriptsList as $script) {
            if (strpos($script, 'td-') === 0 && file_exists(stream_resolve_include_path('Threedom/Core/Scripts/'.$script.'.js'))) {
                $scripts[] = '<script>'.file_get_contents('Threedom/Core/Scripts/'.$script.'.js', true).'</script>';
            }
            else if (file_exists('Scripts/'.ucfirst($script).'.js')){
                $scripts[] = '<script src="Scripts/'.ucfirst($script).'.js"></script>';
            }
        }
        
        // Add jquery first if scripts are registered
        if (!empty($scripts)) {
            array_unshift($scripts, '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>');
        }
        
        return implode("\n", $scripts);
    }
    
    /**
     * Returns all registered widgets in HTML
     * 
     * @access private
     * @return string
     */
    private function _printTemplates() {
        return implode("\n", $this->_widgetsList);
    }
    
    /**
     * Registers styles to the HTML document
     * 
     * @access private
     * @param array $styles
     */
    private function _registerStyles($styles) {
        foreach ($styles as $style) {
            if (!in_array($style, $this->_stylesList)) {
                $this->_stylesList[] = (string)$style;
            }
        }
    }
    
    /**
     * Registers scripts to the HTML document
     * 
     * @access private
     * @param array $scripts
     */
    private function _registerScripts($scripts) {
        foreach ($scripts as $script) {
            if (!in_array($script, $this->_scriptsList)) {
                $this->_scriptsList[] = (string)$script;
            }
        }
    }
    
}
