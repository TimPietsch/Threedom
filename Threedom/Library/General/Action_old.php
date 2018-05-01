<?php
namespace Threedom\Library\General;

/**
 * Description of Directive
 * 
 * @todo documentation
 * @abstract
 * @author TimPietsch
 */
abstract class Action {
    
    use DataAccess;
    
    /* PUBLIC */
    
    public final function __invoke() {
        $this->action();
        return $this->run();
    }
    
    /* PROTECTED */
    
    protected function run() { }
    
    protected abstract function action();
}
