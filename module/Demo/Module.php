<?php namespace Demo;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ControllerProviderInterface{


     public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerConfig(){
        return [
            'initializers' => [
                'Demo\Service\DemoServiceInitializer'
            ]
        ];
    }
}
