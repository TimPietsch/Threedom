<?php

namespace Threedom\Core\Library\Traits;

use Threedom\Core;

trait CheckFile {

    protected function checkAppJson($folder, $file) {
        $cfg = new Core\Classes\Configuration();
        $appDir = $cfg->getAppDir();

        return file_exists($appDir.'/'.$folder.'/'.$file.'.json');
    }

}
