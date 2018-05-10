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
            self::$_viewportCfg['Id'] = Core\Configuration::getViewportId();
            self::$_viewportCfg['Dir'] = Core\Configuration::getViewportDir();
            self::$_viewportCfg['Path'] = self::$_viewportCfg['dir'] . '/Actions/' . $action . '.php';

            self::$_appCfg['id'] = Core\Configuration::getAppId();
            self::$_appCfg['dir'] = Core\Configuration::getAppDir();
            self::$_appCfg['path'] = self::$_appCfg['dir'] . '/Actions/' . $action . '.php';
        }

        // operate only if corresponding action is defined
        $actionClass = null;

        // First check viewport path
        if (file_exists(self::$_viewportCfg['path'])) {
            $actionClass = 'Threedom\\Viewports\\' . self::$_viewportCfg['id'] . '\\Actions\\' . $action;
        }
        // Then check app path for overrides
        if (file_exists(self::$_appCfg['path'])) {
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
