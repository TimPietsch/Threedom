<?php

namespace Threedom\Viewports\Console\Classes;

use Threedom\Core\Library;

abstract class Action extends Library\Classes\Action {

    use Library\Traits\PostData;

    public function __construct() {
        $this->filterPostData();
    }

    protected function postDataFields() {
        return [
            'message',
            'timestamp'
        ];
    }

}
