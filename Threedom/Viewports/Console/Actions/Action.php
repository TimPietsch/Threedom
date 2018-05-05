<?php

namespace Threedom\Viewports\Console\Actions;

use Threedom\Library\Classes;
use Threedom\Library\Traits;

abstract class Action extends Classes\Action {

    use Traits\PostAccess;

    public function __construct() {
        $this->setPostData();
    }

    protected function postDataFields() {
        return [
            'message',
            'timestamp'
        ];
    }

}
