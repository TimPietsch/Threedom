<?php

namespace Threedom\Core\Library\Traits;

/**
 * @todo documentation
 */
trait PostAccess {

    /**
     * @todo documentation
     */
    protected abstract function postDataFields();

    /**
     * Initializes post data for the calling class
     * 
     * @access protected
     * @uses PostAccess::postDataFields to determine which POST fields will be provided.
     * @return bool <b>TRUE</b> on success, <b>FALSE</b> otherwise.
     */
    protected function setPostData() {
        foreach ($_POST as $key => $value) {
            
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
