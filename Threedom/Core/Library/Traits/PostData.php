<?php

namespace Threedom\Core\Library\Traits;

/**
 * Provides access to the data sent via POST method
 * 
 * @todo documentation
 * @todo provide filter security
 */
trait PostData {

    /**
     * Returns the POST data fields that can be accessed
     * 
     * Is interpreted as array('key', ...)
     * 
     * @todo modify structure to provide filter options
     * @access protected
     * @return array The fields that should be provided from the POST data
     */
    protected abstract function postDataFields();

    /**
     * Initializes post data for the calling class
     * 
     * @todo Filter values based on configuration in postDataFields();
     * @access protected
     * @uses PostAccess::postDataFields to determine which POST fields will be provided.
     * @return bool <b>TRUE</b> on success, <b>FALSE</b> otherwise.
     */
    protected function setPostData() {
        // read field configuration
        $keys = $this->postDataFields();

        // iterate over $_POST and filter out illegal fields
        foreach ($_POST as $key => $value) {
            if (in_array($key, $keys)) {
                $this->_post[$key] = $value;
            }
        }
    }

    /**
     * @todo documentation
     */
    protected function getPostData($key = null) {
        $return = [];

        if ($key === null) {
            $return = $this->_post;
        } else {
            $return = $this->_post[$key];
        }

        return $return;
    }

    private $_post = [];

}
