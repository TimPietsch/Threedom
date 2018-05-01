<?php

namespace Threedom\Library\General;

/**
 * Description of Viewport
 * @todo documentation
 */
abstract class Viewport {

    public final function __toString() {

        $this->registerScripts();
        $this->registerStyles();

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

    public abstract function registerScripts();

    public abstract function registerStyles();

    private function _printStyles() {
        return "<!-- Styles -->";
    }

    private function _printScripts() {
        return "<!-- Scripts -->";
    }

    private function _printTitle() {
        return "<title>TITLE</title>";
    }

}
