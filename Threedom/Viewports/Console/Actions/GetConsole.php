<?php

namespace Threedom\Viewports\Console\Actions;

use Threedom\Core\Library;

class GetConsole extends Library\Classes\Action {

    use Library\Traits\CheckFile;

    public function __construct() {
        
    }

    public function __invoke($args) {
        $response = [];

//        foreach ($args as $id) {
//            if ($this->checkAppJson('Console', $id)) {
//                $response[] = $this->_clientJson($id);
//            }
//        }

        $response['asdf'] = 'ghjk';

        return $response;
    }

    private function _clientJson($id) {
        
    }

}
