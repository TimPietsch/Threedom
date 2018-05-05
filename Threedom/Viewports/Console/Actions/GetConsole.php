<?php

namespace Threedom\Viewports\Console\Actions;

use Threedom\Core;
use Threedom\Core\Library;

class GetConsole extends Library\Classes\Action {

    use Library\Traits\CheckFile;

    public function __construct() {
        $cfg = new Core\Classes\Configuration();
        $this->_appDir = $cfg->getAppDir();
    }

    public function __invoke($args) {
        $response = [];

        foreach ($args as $id) {
            if ($this->checkAppJson('Console', $id)) {
                $response[] = $this->_clientJson($id);
            } else {
                
            }
        }

        return $response;
    }

    private function _clientJson($id) {
        $cfgJson = json_decode(file_get_contents($this->_appDir.'/Console/'.$id.'.json'));

        $clientJson = [
            "id" => $cfgJson->id ?? $id,
            "title" => $cfgJson->title ?? 'stdTitle',
            "disabled" => $cfgJson->disabled ?? true
        ];

        return $clientJson;
    }

}
