<?php namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Financial\Model\Income;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface, ControllerProviderInterface, FormElementProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface{
    
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

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getControllerConfig() {
        return [
            'abstract_factories' => [
                'Application\Controller\Factory\ControllerFactoryAbstract'
            ]
        ];
    }
    
    public function getFormElementConfig() {
        return [
            'abstract_factories' => [
                'Application\Form\Factory\FieldsetFactoryAbstract'
            ]
        ];
    }

    public function getServiceConfig() {
        return [
            'abstract_factories' => [
                'Application\Service\Factory\DbServiceFactoryAbstract',
                'Application\Model\Factory\DbModelFactoryAbstract',
                'Application\Factory\DbTableFactoryAbstract'
            ],
            'initializers' => [
                'Application\Model\ModelAbstractInitializer'
            ]
        ];
    }

    public function getViewHelperConfig() {
        return [
            'invokables' => [
                'FormDate' => 'Application\Form\View\Helper\FormDate'
            ]
        ];
    }
}
