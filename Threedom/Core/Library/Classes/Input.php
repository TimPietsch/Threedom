<?php
namespace Threedom\Library\General;

/**
 * Description of Input
 * 
 * @todo get rid of direct super globals
 * @author Beef
 */
class Input {
    
    /* PUBLIC */
    
    public function __construct($channel) {
        switch (strtolower($channel)) {
            case 'get':
                $this->_type = INPUT_GET;
                $this->_channel = $_GET;
                break;
            case 'post':
                $this->_type = INPUT_POST;
                $this->_channel = $_POST;
                break;
            case 'cookie':
                $this->_type = INPUT_COOKIE;
                $this->_channel = $_COOKIE;
                break;
            case 'session':
                $this->_type = INPUT_SESSION;
                $this->_channel = $_SESSION;
                break;
            
            default:
                $this->_type = null;
                $this->_channel = array();
        }
    }
    
    /**
     * Determines if a given parameter is present in the input set
     * 
     * If no parameter is specified, returns <b>true</b> if there are any parameters,
     * <b>false</b> otherwise.
     * 
     * @param string $name [optional] The name of a parameter
     * @return boolean <b>true</b> if the parameter exists in the input, <b>false</b> otherwise
     */
    public function hasParameter($name = null) {
        if ($name === null) {
            $r = !empty($this->_channel);
        }
        else if ($this->_type === INPUT_SESSION) {
            $r = array_key_exists($name, $this->_channel);
        }
        else {
            $r = !(filter_input($this->_type, (string)$name) === null);
        }
        
        return $r;
    }
    
    public function getParameter($name) {
        switch ($this->_type) {
            case INPUT_GET:
                $ret = filter_input(INPUT_GET, (string)$name);
                break;
            default:
                break;
        }
        
        return $ret;
    }
    
    /* PRIVATE */
    
    private $_type;
    private $_channel;

}
