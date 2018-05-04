<?php

namespace Threedom\Library\General;

/**
 * Description of Action
 * 
 * @todo documentation
 * @abstract
 */
abstract class Action {

    public function __construct($post) {
//        foreach ($post as $fieldname => $value) {
//            $fields = $this->dataFields();
//            if (in_array($fieldname, $fields)) {
//                $this->_post[$fieldname] = $value;
//            }
//        }

        $this->_post = $post;
    }

    public abstract function __invoke($args);

    public function dataFields() {
        
    }

    protected function postData() {
        return $this->_post;
    }

    private $_post = [];

}
