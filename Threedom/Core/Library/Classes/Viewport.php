<?php

namespace Threedom\Core\Library\Classes;

use Threedom\Core\Classes;

/**
 * Description of Viewport
 * 
 * @todo documentation
 */
abstract class Viewport {

    public final function __construct() {
        $this->_registerScripts($this->scripts());
        $this->_registerStyles($this->styles());
        $this->_registerBody($this->body());
    }

    public final function __invoke($get) {
        // Get application directory
        $cfg = new Classes\Configuration();
        $appDir = $cfg->getAppDir();

        // Iterate over requested actions
        foreach ($get as $action => $args) {
            // operate only if corresponding action is defined
            $path = $appDir.'/Actions/'.(string)$action;
            $actionClass = file_exists($path.'.php') ? str_replace('/', '\\', $path) : null;

            if ($actionClass !== null) {
                $action = new $actionClass();
                $response[] = $action((array)$args);
            }
        }

        // return assembled response json
        // TODO: move header() to header management class
//        header('Content-Type: application/json');
        return json_encode($response);
    }

    public final function __toString() {
        return <<<END_OF_DOCUMENT
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    {$this->_printTitle()}
    <link rel="stylesheet" href="Threedom/Core/Styles/threedom.css">
    <link rel="stylesheet" href="Threedom/Core/Styles/viewport.css">
    {$this->_printStyles()}
    {$this->_printScripts()}
</head>
<body class="threedom">
    {$this->_printBody()}
</body>
</html>
END_OF_DOCUMENT;
    }

    /**
     * @todo documentation
     */
    protected abstract function styles();

    /**
     * @todo documentation
     */
    protected abstract function scripts();

    /**
     * @todo documentation
     */
    protected abstract function body();

    /**
     * @todo documentation
     * @todo dynamically get project path
     */
    protected function json($path) {
        return json_decode(file_get_contents('Examples/'.$path), true);
    }

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
    private function _registerBody($body) {
        $this->_body = (string)$body;
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

    /**
     * @todo documentation
     */
    private function _printBody() {
        return $this->_body;
    }

    private $_scriptFiles = array();
    private $_styleFiles = array();
    private $_body = '';

    /**
     * @todo documentation
     */
    private function _viewportDir() {
        $dirs = explode('\\', get_class($this));
        array_pop($dirs);
        return implode('/', $dirs);
    }

}
