<?php

namespace Threedom\Viewports\ViewportTest;

use Threedom\Library\General;

class Viewport extends General\Viewport {

    public function scripts() {
        return [
            'Scripts/getMapJson.js'
        ];
    }

    public function styles() {
        return [
            'Styles/style.css'
        ];
    }

}
