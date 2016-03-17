<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    private $_acl = null;
    private $_config = null;
     private $_logger = null;

    protected function _initAutoload() {

        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH . '/application/models'));
        return $autoloader;
    }

    protected function _initSession() {

        Zend_Session::start();
        $sessionNamespace = new Zend_Session_Namespace('testing');

        Zend_Registry::set('sessionNamespace', $sessionNamespace);
    }

    protected function _initMainRouters() {
        $this->bootstrap('frontController');
        $router = $this->getResource('frontController')->getRouter();

        $route_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'routes');
        $router->addConfig($route_config, 'routes');

        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
    }
    
     protected function _initLogs() {
            $this->_logger = new Zend_Log();
            $fireBugWriter = new Zend_Log_Writer_Firebug();
            $this->_logger->addWriter($fireBugWriter);
            Zend_Registry::set('logger', $this->_logger);
        }
    
    
    protected function _initAppDefaults() {
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/appsettings.ini', 'appConfig');
        Zend_Registry::set('appconfig', $this->_config);
    }
      protected function _initLoadPlugins() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Engine_');
        $objPluginLoader = Engine_Plugins_PluginLoader::getInstance();
//        echo "<pre>"; print_r($objPluginLoader); die;
//        $objPluginLoader->registerPlugin();
    }

}
