<?php
namespace Threedom\Core\Modules;

//use \Threedom\Core;
use \Threedom\Library\Html;
use \Threedom\Library\Traits\Configuration;

class Backend extends Html\Widget {
    
    /* PROTECTED */
    
    protected function setup() {
        $this->setContext(new Html\Context('<main class="left-frame">'));
        
        $this->addStyle('td-panel-frame');
        $this->addStyle('td-backend');
        
        $this->_loadClass();
    }
    
    protected function getData() {
        $data = array();
        
        $data['title'] = 'Überschrift';
        $data['widgets'] = $this->_loadWidgets();
        
        return $data;
    }
    
    /* PRIVATE */
    
    private $_class;
    
    private function _loadClass() {
        $get = $this->getInput('get');
        
        $config = new Configuration();
        $settings = $config->getConfig('Threedom\Core\Configuration');
        
        foreach (new \DirectoryIterator($settings['system']['root'].'/Plugins') as $file) {
            // Skip on '.' and '..'
            if ($file->isDot()) { continue; }
            
            // Skip wrong files
            if ($get->getParameter($settings['admin']['directive']).'.php' !== $file->getFilename()) { continue; }
            
            // Get object information
            $this->_class = 'Plugins\\'.substr($file->getFilename(), 0, -4);
        }
    }
    
    private function _loadWidgets() {
        $widgets = array();
        
        // Setup interfaces array
        $interfaces = array();
        if (is_string($this->_class) || is_object($this->_class)) {
            $interfaces = class_implements($this->_class);
        }
        
        // Check for interfaces to determine the widgets
        foreach ($interfaces as $interface) {
            if (!(strpos($interface, 'Threedom\Core\Interfaces\i') === 0)) { continue; }
            $widget = str_replace('Threedom\Core\Interfaces\i', '', $interface);
            $widgets[] = array(
                'widget'    => $widget,
                'interface' => $interface
            );
        }
        
        return $widgets;
    }
    
}
