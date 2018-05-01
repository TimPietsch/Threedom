<?php

namespace Threedom\Viewports\ViewportTest;

use Threedom\Library\General;

class Viewport extends General\Viewport {

    public function registerScripts() {
        return [
            'Scripts/getMapJson.js'
        ];
    }

    public function registerStyles() {
        return [
            'Styles/style.css'
        ];
    }

}
