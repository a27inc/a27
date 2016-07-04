<?php namespace Auth;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

use Zend\EventManager\EventInterface;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface, ServiceProviderInterface{
    
    public function getAutoloaderConfig(){
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ]
            ]
        ];
    }

    public function onBootstrap(EventInterface $e){
        $t = $e->getTarget();
        $t->getEventManager()->attach(
            $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy'));
        $t->getEventManager()->attach(
            $t->getServiceManager()->get('ZfcRbac\View\Strategy\UnauthorizedStrategy'));
    }

    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig(){
        return [
            'aliases' => [
                'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service'
            ],
            'initializers' => [
                'Auth\Service\AuthServiceInitializer'
            ],
        ];
    }
}
