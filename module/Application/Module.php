<?php namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

use Zend\EventManager\EventInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface, ServiceProviderInterface{
    
    public function getAutoloaderConfig(){
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function onBootstrap(EventInterface $e){
        // TODO: What is this for exactly?
        $em = $e->getApplication()->getEventManager();
        $ml = new ModuleRouteListener();
        $ml->attach($em);
    }

    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig(){
        return [
            'abstract_factories' => [
                'Application\Factory\DbServiceFactoryAbstract',
                'Application\Factory\DbTableFactoryAbstract'
            ]
        ];
    }
}
