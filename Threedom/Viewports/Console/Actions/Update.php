<?php

namespace Threedom\Viewports\Console\Actions;

use Threedom\Library\General;

class Update extends General\Action {

    public function __invoke($args) {
        $post = $this->postData();

        $response = $post;

        return $response;
    }

    public function dataFields() {
        return [
            'message'
        ];
    }

}
