<?php
namespace Threedom\Library\Html\Interfaces;

use Threedom\Library\Html;

interface iWidget {
    public function __construct($string, Html\Context $context);
    public function getStyles();
    public function getScripts();
    public function __tostring();
}