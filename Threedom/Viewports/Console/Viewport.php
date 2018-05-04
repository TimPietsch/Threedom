<?php

namespace Threedom\Viewports\Console;

use Threedom\Library\General;

class Viewport extends General\Viewport {

    protected function scripts() {
        return [
            'Scripts/jquery-3.3.1.min.js',
            'Scripts/update.js'
        ];
    }

    protected function styles() {
        return [
            "Styles/vp-viewport.css",
            "Styles/vp-console.css"
        ];
    }

    protected function body() {
        $body = "<div id='viewport'>";

        $body .= $this->_consoles();

        $body .= "</div>";

        return $body;
    }

    private function _consoles() {
        $consoles = '';

        foreach ($this->json('Console/console.json') as $console) {
            $consoles .= "<form class='vp-console' id='{$console['id']}'>";

            $consoles .= "<div class='vp-log'></div>";

            $consoles .= "<input type='text'>";

            $consoles .= "<input type='submit'>";

            $consoles .= "</form>";
        }

        return $consoles;
    }

}
