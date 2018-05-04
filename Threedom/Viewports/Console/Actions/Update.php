<?php

namespace Threedom\Viewports\Console\Actions;

use Threedom\Library\General;

class Update extends General\Action {

    public function __invoke($args) {
        $response = [];

        $i = 0;
        foreach ($args as $value) {
            $response[] = $value.$i++;
        }

        return $response;
    }

}
