<?php

namespace Threedom\Library\General;

/**
 * Description of Directive
 * 
 * @todo documentation
 * @abstract
 */
abstract class Action {

    public final function __invoke() {
        $this->action();
        return;
    }

    /**
     * @todo documentation
     */
    protected abstract function action();
}
