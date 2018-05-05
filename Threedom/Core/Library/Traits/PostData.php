<?php

namespace Threedom\Core\Library\Traits;

/**
 * Provides access to the data sent via POST method
 * 
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
    protected function filterPostData() {
        // read field configuration
        $keys = $this->postDataFields();

        // iterate over $_POST and filter out illegal fields
        foreach ($keys as $key) {
            if (array_key_exists($key, $_POST)) {
                $this->_post[$key] = $_POST[$key];
            } else {
                $this->_post[$key] = null;
            }
        }
    }

    /**
     * Returns POST data
     * 
     * PostData\setPostData() must have been called before this is called, or all return
     * values will be <b>NULL</b>.
     * 
     * @access protected
     * @param string $key The POST data field which should be returned
     * @return mixed The field data or the whole POST data according to specified fields
     */
    protected function getPostData($key = null) {
        if ($key === null) {
            $return = $this->_post;
        } else {
            $return = $this->_post[$key];
        }

        return $return;
    }

    /**
     * The filtered POST data
     * 
     * @access private
     * @var array 
     */
    private $_post = [];

}
