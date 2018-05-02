<?php

namespace Threedom\Viewports\ViewportTest\Classes;

/**
 * Description of Map
 * 
 */
class Map {

    /**
     * 
     * 
     * @param int $id
     */
    public function __construct($id) {
        // Check if map exists
        // TODO: change to dynamic game id
        if (file_exists("Examples/World/Maps/".(int)$id.".json")) {
            // Only integer ids are allowed
            $this->_id = (int)$id;
        } else {
            $this->_id = false;
        }

        // Read world .json file
        // TODO: change to dynamic game id
        if ($this->_id !== false) {
            $json = file_get_contents("Examples/World/Maps/".$this->_id.".json");
            $this->_originalJson = json_decode($json, true);
        }
    }

    public function clientData() {
        if ($this->_id !== false) {
            return $this->_originalJson;
        } else {
            return null;
        }
    }

    /**
     *
     * @var int 
     */
    private $_id;

    /**
     * Array generated from world .json file
     * 
     * @var array 
     */
    private $_originalJson;

}
