<?php
namespace Threedom\Library\General;

/**
 * Description of Directive
 * 
 * @todo documentation
 * @abstract
 * @author Beef
 */
abstract class Directive extends DataAccess {
    
    /* PUBLIC */
    
    public final function __invoke() {
        $this->directive();
        return $this->run();
    }
    
    /* PROTECTED */
    
    protected function run() { }
    
    protected abstract function directive();
}
