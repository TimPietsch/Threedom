<?php

namespace Threedom\Viewports\Consolog;

use Threedom\Library\General;

class Viewport extends General\Viewport {

    protected function scripts() {
        return [
            'Scripts/update.js'
        ];
    }

    protected function styles() {
        return [
        ];
    }

    protected function body() {
        $body = '';

        $body .= $this->_console($this->json('Consolog/console.json'));

        return $body;
    }

    private function _console($array) {
        return "<input type='text' id='{$array[0]['id']}' value='{$array[0]['log']}'>";
    }

}
