<?php namespace Financial;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\HydratorProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ControllerProviderInterface, FormElementProviderInterface{

    public function getAutoloaderConfig(){
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerConfig(){
        return [
            'initializers' => [
                'Financial\Service\FinancialServiceInitializer'
            ]
        ];
    }

    public function getFormElementConfig(){
        return [
            'initializers' => [
                'Financial\Model\CategoriesTableInitializer',
                'Financial\Model\RatesTableInitializer'
            ],
            'invokables' => [
                'ExpenseForm' => 'Financial\Form\ExpenseForm',
                'IncomeForm' => 'Financial\Form\IncomeForm',
                'CategoriesFieldset' => 'Financial\Form\CategoriesFieldset',
                'RatesFieldset' => 'Financial\Form\RatesFieldset',
                'ReportFieldset' => 'Financial\Form\ReportFieldset',
            ]
        ];
    }
}
