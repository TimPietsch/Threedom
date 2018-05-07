<?php

namespace Threedom\Core\Library\Classes;

/**
 * Description of Action
 * 
 * @todo documentation
 * @abstract
 */
abstract class Action {

    public abstract function __construct();

    public abstract function __invoke($params);
}
