<?php
namespace Threedom\Core\Modules;

use \Threedom\Library\Html;
use \Threedom\Library\Traits\Configuration;

class Menu extends Html\Widget {
    
//    use \Threedom\Library\Traits\Configuration;
    
    /* PROTECTED */
    
    protected function defaultConfig() {}
    
    protected function setup() {
        $this->_loadObjects();
        
        $this->setContext(new Html\Context('<section class="left-frame side-menu">'));
        
        $this->addScript('td-menu-section');
        
        $this->addStyle('td-link-list');
        $this->addStyle('td-side-menu');
    }
    
    protected function getData() {
        $data = array();
        
        $data['title'] = PROJECT_NAME;
        $data['objects'] = $this->_objects;
        $data['links'] = array(
            array('name' => 'Directives')
        );
        
        return $data;
    }
    
    /* PRIVATE */
    
    private $_objects = array();
    
    private function _loadObjects() {
//        var_dump($this->getConfig('Threedom\Core\Configuration'));
        
        $config = new Configuration();
        $settings = $config->getConfig('Threedom\Core\Configuration');
        
        foreach (new \DirectoryIterator($settings['system']['root'].'/Plugins') as $file) {
            // Skip on '.' and '..'
            if ($file->isDot()) { continue; }
            
            // Get object information
            $class = substr($file->getFilename(), 0, -4);
            $name = substr($class, 0, -6);
            $this->_objects[] = array(
                'name' => $name,
                'class' => $class
            );
        }
    }
}
