<?php
namespace Threedom\Library\General\Interfaces;

/**
 * Interface for providing an object to the AutoAPI
 * 
 * @todo Needed at all?
 * @author Beef
 */
interface iAutoApi {
    
    /* PUBLIC */
    
    /**
     * Returns the model's JSON representation
     * 
     * @return string The JSON
     */
    public function json();
}