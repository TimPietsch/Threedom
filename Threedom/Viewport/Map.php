<?php
namespace Threedom\Viewport;

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
        
        // only integer ids are allowed
        $this->_id = (int)$id;
        
        // Read world .json file
        // TODO: change to dynamic game id
        $json = file_get_contents("Examples/Maps/".$this->_id.".json");
        $this->_originalJson = json_decode($json, true);
        
        // tests
        echo "<pre>";
        var_dump($this->_originalJson);
        echo "</pre>";
        
    }
    
    public function getClientJson() {
        return "";
    }
    
    /**
     *
     * @var type 
     */
    private $_id;
    
    /**
     * Array generated from world .json file
     * 
     * @var array 
     */
    private $_originalJson;
}
