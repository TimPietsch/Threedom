<?php

namespace Threedom\Library\General;

/**
 * Description of Action
 * 
 * @todo documentation
 * @abstract
 */
abstract class Action {

    public function __construct($post) {
        $afds;
    }

    public abstract function __invoke($args);
}
