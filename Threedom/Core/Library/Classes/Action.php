<?php

namespace Threedom\Core\Library\Classes;

use Threedom\Core\Classes as Core;

/**
 * Description of Action
 * 
 * @todo documentation
 * @abstract
 */
abstract class Action {

    /**
     * @todo documentation
     */
    public abstract function __invoke($params);

    /**
     * @todo documentation
     * @param string $action
     * @param array $params
     */
    public static function call($action, $params) {
        // TODO: maybe move to seperate initalize function?
        if (!self::$_isInitialized) {
            self::$_viewportCfg['id'] = Core\Configuration::getViewportId();
            self::$_viewportCfg['dir'] = Core\Configuration::getViewportDir();

            self::$_appCfg['id'] = Core\Configuration::getAppId();
            self::$_appCfg['dir'] = Core\Configuration::getAppDir();

            self::$_isInitialized = true;
        }

        // operate only if corresponding action is defined
        $actionClass = null;

        $viewportPath = self::$_viewportCfg['dir'] . '/Actions/' . $action . '.php';
        $appPath = self::$_appCfg['dir'] . '/Actions/' . $action . '.php';

        // First check viewport path
        if (file_exists($viewportPath)) {
            $actionClass = 'Threedom\\Viewports\\' . self::$_viewportCfg['id'] . '\\Actions\\' . $action;
        }
        // Then check app path for overrides
        if (file_exists($appPath)) {
            $actionClass = self::$_appCfg['id'] . '\\Actions\\' . $action;
        }

        // Run action and fill response
        if ($actionClass !== null) {
            $action = new $actionClass();
            return $action((array)$params);
        }
    }

    /**
     * @access private
     * @var boolean 
     */
    private static $_isInitialized = false;

    /**
     * @access private
     * @var array 
     */
    private static $_viewportCfg;

    /**
     * @access private
     * @var array 
     */
    private static $_appCfg;

}
