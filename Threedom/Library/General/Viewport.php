<?php

namespace Threedom\Library\General;

/**
 * Description of Viewport
 * @todo documentation
 */
abstract class Viewport {

    public final function __construct() {
        $this->_registerScripts($this->scripts());
        $this->_registerStyles($this->styles());
    }

    public final function __invoke($get, $post) {

        // Get current viewport's directory
        $dir = $this->_viewportDir();

        // Iterate over requested actions
        foreach ($get as $action => $args) {
            // operate only if corresponding action is defined
            $path = $dir.'/Actions/'.$action;
            if (file_exists($path.'.php')) {
                $actionClass = str_replace('/', '\\', $path);
                $action = new $actionClass();
                $response = $action($args);
            } else {
                $response = ['No' => 'Action'];
            }
        }

        // return assembled response json
        return json_encode($response);
    }

    public final function __toString() {
        return <<<END_OF_DOCUMENT
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    {$this->_printTitle()}
    {$this->_printStyles()}
    {$this->_printScripts()}
</head>
<body>
    <div>Hallo Welt!</div>
</body>
</html>
END_OF_DOCUMENT;
    }

    /**
     * @todo documentation
     */
    public abstract function styles();

    /**
     * @todo documentation
     */
    public abstract function scripts();

    /**
     * @todo documentation
     */
    private function _registerStyles($files) {
        // Get viewport directory
        $dir = $this->_viewportDir();

        // Iterate over files
        foreach ($files as $file) {
            // Generate file path from file name
            $path = $dir.'/'.$file;

            // Check if file exists
            if (file_exists($path) && !in_array($path, $this->_styleFiles)) {
                // Register file once
                $this->_styleFiles[] = $path;
            }
        }
    }

    /**
     * @todo documentation
     */
    private function _registerScripts($files) {
        // Get viewport directory
        $dir = $this->_viewportDir();

        // Iterate over files
        foreach ($files as $file) {
            // Generate file path from file name
            $path = $dir.'/'.$file;

            // Check if file exists
            if (file_exists($path) && !in_array($path, $this->_scriptFiles)) {
                // Register file once
                $this->_scriptFiles[] = $path;
            }
        }
    }

    /**
     * @todo documentation
     */
    private function _printStyles() {

        $tags = '';

        foreach ($this->_styleFiles as $file) {
            $tags .= "<link rel='stylesheet' href='$file'>";
        }

        return $tags;
    }

    /**
     * @todo documentation
     */
    private function _printScripts() {

        $tags = '';

        foreach ($this->_scriptFiles as $file) {
            $tags .= "<script src='$file'></script>";
        }

        return $tags;
    }

    /**
     * @todo implementation
     */
    private function _printTitle() {
        return "<title>TITLE</title>";
    }

    private $_scriptFiles = array();
    private $_styleFiles = array();

    /**
     * @todo documentation
     */
    private function _viewportDir() {
        $dirs = explode('\\', get_class($this));
        array_pop($dirs);
        return implode('/', $dirs);
    }

}
