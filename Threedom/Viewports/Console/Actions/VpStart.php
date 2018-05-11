<?php

namespace Threedom\Viewports\Console\Actions;

use Threedom\Core\Library as Core;

class VpStart extends Core\Classes\Action {

    public final function __invoke($params) {
        $response = [];

        $response['consoles'] = $this->_callAction('VpConsole', $this->consoles());

        return $response;
    }

    /**
     * Return an indexed array of Console IDs.
     * 
     * The IDs should correspond to consoles defined in your Application/Console folder
     * as .json files.
     * 
     * @access protected
     * @return array The Console IDs
     */
    protected function consoles() {
        
    }

    private function _callAction($action, $params) {

        if ($params == null) {
            $params = [];
        }

        return Core\Classes\Action::call($action, $params);
    }

}
