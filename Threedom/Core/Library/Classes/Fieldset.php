<?php
namespace Threedom\Library\General;

class Fieldset {
    
    /* PUBLIC */
    
    public function __construct() {
        
    }
    
    public function addScalarField($name, $type = 'text', $label = '') {
        // make sure the field name is not empty
        if (empty($name)) {
            $return = false;
        }
        else {
            // Set name
            $name = (string)$name;
            
            // Set label
            $label = $this->_label($name, $label);
            
            // Set type
            $types = array(
                'text',
                'textarea',
                'color'
            );
            $type = in_array(strtolower($type), $types) ? strtolower($type) : 'text';
            
            // Add field
            $this->_fields[] = array(
                'name'  => $name,
                'label' => $label,
                'type'  => $type
            );
            
            $return = true;
        }
        
        return $return;
    }
    
    public function addReferenceField($name, $data, $count = 0, $label = '') {
        if (empty($name)) {
            $return = false;
        }
        else {
            // Set name
            $name = (string)$name;
            
            // Set label
            $label = $this->_label($name, $label);
            
            // Set options
            switch (gettype($data)) {
                case 'array':
                    break;
                case 'string':
                    break;
                default:
                    break;
            }
            
            // Add field
            $this->_fields[] = array(
                'name' => $name,
                'label' => $label,
                'count' => $count,
                'options' => $options
            );
            
            $return = true;
        }
        
        return $return;
    }
    
    /* PRIVATE */
    
    private $_fields = array();
    
    /**
     * Generates a label from the passed value
     * 
     * @access private
     * @param string $string
     * @return string The label
     */
    private function _label($name, $label) {
        return !empty($label) ? (string)$label : ucfirst($name);
    }
}