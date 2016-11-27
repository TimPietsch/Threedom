<?php
namespace Threedom\Core\Modules;

use \Threedom\Library\Html;

class Menu extends Html\Object {
    
    /* PROTECTED */
    
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
        foreach (new \DirectoryIterator(SYSTEM_ROOT.'/Objects') as $file) {
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
