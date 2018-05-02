<?php

namespace Threedom\Viewports\ViewportTest\Actions;

use Threedom\Library\General;
use Threedom\Viewports\ViewportTest\Classes\Map;

class GetMap extends General\Action {

    public function __invoke($args) {
        // Initialize response array
        $response = array();

        // Create requested maps
        foreach (array($args) as $id) {
            $map = new Map($id);

            if (($data = $map->clientData()) !== null) {
                $response[] = $data;
            } else {
                echo __FILE__.':'.__LINE__."\n";
            }
        }

        return $response;
    }

}
