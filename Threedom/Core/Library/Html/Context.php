<?php
namespace Threedom\Library\Html;

/**
 * Used to refer to HTML contexts of widgets and elements
 *
 * @deprecated
 */
class Context {
    
    /* PUBLIC */
    
    /**
     * Creates an HTML context with an element of the provided tag
     * 
     * @param string
     */
    public function __construct($string = null, $exclude = null) {
        // Generate context from string
        $matches = array();
        preg_match('/<([a-zA-Z]\w*)( [^>]*)?>/',(string)$string, $matches);
        
        // Set tag
        if (isset($matches[1])) {
            $this->setTag(strtolower($matches[1]));
        }
        
        // Add attributes to HTML context
        if (isset($matches[2])) {
            $attributes = array();
            preg_match_all('/([A-Za-z\-_]+)=[\'"]((?:\\[\'"]|.)+?)"/', $matches[2], $attributes, PREG_SET_ORDER);
            foreach($attributes as $item) {
                if ($item[1] !== $exclude) {
                    $this->setAttribute($item[1], $item[2]);
                }
            }
        }
    }
    
    /**
     * Updates the HTML context information with data from the passed object
     * 
     * @param \Threedom\Modules\Html\Context $context
     */
    public function update(Context $context) {
        // Update tag
        $this->_tag = $context->getTag();
        
        // Update attributes
        foreach ($context->getAttributes() as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        }
    }
    
    /**
     * Sets the context element's tag
     * 
     * @param string $tag
     */
    public function setTag($tag) {
        $this->_tag = (string)$tag;
    }
    
    /**
     * Adds an attribute to the sorrounding element
     * 
     * @todo maybe include arrays?
     * @param string $attribute The attribute name
     * @param string $value The new value
     */
    public function setAttribute($attribute, $value) {
        $this->_attributes[strtolower((string)$attribute)] = $value;
    }
    
    /**
     * Encases the passed content in tags generated from the context settings
     * 
     * @param string $content
     * @return string
     */
    public function encase($content) {
        // Generate attributes
        $attributes = '';
        foreach ($this->_attributes as $attribute => $value) {
            $attributes .= ' '.strtolower($attribute).'="';
            $values = is_array($value) ? implode(' ', $value) : (string)$value;
            $attributes .= $values.'"';
        }
        
        // Return encased content
        return '<'.$this->_tag.$attributes.'>'.$content.'</'.$this->_tag.'>';
    }
    
    /* PROTECTED */
    
    /**
     * Returns this context's HTML element tag
     * 
     * @access protected
     * @return string
     */
    protected function getTag() {
        return (string)$this->_tag;
    }
    
    /**
     * Returns the attributes of this context's HTML element
     * 
     * @access protected
     * @return array
     */
    protected function getAttributes() {
        return (array)$this->_attributes;
    }
    
    /* PRIVATE */
    
    private $_tag = 'div';
    private $_attributes = array();
    
}
