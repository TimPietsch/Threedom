<?php

namespace Threedom\Viewports\Console\Actions;

use Threedom\Core\Library;

abstract class Action extends Library\Classes\Action {

    use Library\Traits\PostAccess;

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
