<?php namespace Investor;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ControllerProviderInterface, FormElementProviderInterface{

    public function getAutoloaderConfig(){
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ]
            ]
        ];
    }

    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerConfig(){
        return [
            'initializers' => [
                'Investor\Service\InvestorServiceInitializer'
            ]
        ];
    }
    
    public function getFormElementConfig(){
        return [
            'initializers' => [
                'Investor\Model\CategoriesTableInitializer'
            ],
            'invokables' => [
                'AllocationCategoriesFieldset' => 'Investor\Form\CategoriesFieldset'
            ]
        ];
    }
}
