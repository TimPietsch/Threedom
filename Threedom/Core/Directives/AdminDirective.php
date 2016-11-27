<?php
namespace Threedom\Core\Directives;

use Threedom\Core\Modules;
use Threedom\Library\Html;

class AdminDirective extends Html\Directive {
    
    /* PUBLIC */
    
    /* PROTECTED */
    
    protected function directive() {
        $this->addStyle('td-Backend_General');
        
        $this->addWidget(new Modules\Menu('Threedom/Core/Templates/MainMenu'));
        $this->addWidget(new Modules\Backend('Threedom/Core/Templates/Backend'));
    }
    
    /* PRIVATE */
    
    private $_objects = array();
    
    /**
     * Creates an html form from the form data stored for the specified object class
     * 
     * @access private
     * @param string $class
     * @return string
     */
    private function _getForm($class) {
        $fields = array();
        $tag = 'form';
        foreach ($this->_objects[$class]['form'] as $name => $type) {
            switch ($type) {
                case 'text':
                case 'color':
                    $label = '<label for="'.$name.'">'.$name.'</label>';
                    $input = '<input id="'.$name.'" type="'.$type.'" name="'.$name.'">';
                    $fields[] = $label.$input;
                    break;
                case 'textarea':
                    $label = '<label for="'.$name.'">'.$name.'</label>';
                    $input = '<textarea id="'.$name.'"></textarea>';
                    $fields[] = $label.$input;
                    break;
                default:
                    $fields[] = '<span>'.$type.'</span>';
                    $tag = 'p';
                    break;
            }
        }
        
        if ($tag !== 'p') {
            array_unshift($fields, '<input type="hidden" name="id">');
        }
        
        return "<$tag>".implode('', $fields)."</$tag>";
    }
    
    private function _getView() {
        // Determine object
        $query = $this->getInput('get');
        
        $name = ADMIN_NAME;
        $form = '';
        foreach ($this->_objects as $class => $object) {
            if ($object['name'] === $query->getParameter(ADMIN_DIRECTIVE)) {
                $name = $object['name'];
                $form = '<section class="backend-panel" style="background-color: '.ADMIN_COLOR_PRI.'">'.$this->_getForm($class).'</section>';
            }
        }
        
        // Return all available options
        return <<<END_OF_OPTIONS
<header>{$name}</header>
{$form}
END_OF_OPTIONS;
    }
    
}
