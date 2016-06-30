<?php namespace SiteUser;

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
                'SiteUser\Service\UserServiceInitializer'
            ]
        ];
    }
    
    public function getFormElementConfig(){
        return [
            'initializers' => [
                'SiteUser\Model\UsersTableInitializer',
                'SiteUser\Model\RolesTableInitializer',
                'SiteUser\Model\PermissionsTableInitializer'
            ],
            'invokables' => [
                'UserForm' => 'SiteUser\Form\UserForm',
                'RoleForm' => 'SiteUser\Form\RoleForm',
                'UsersFieldset' => 'SiteUser\Form\UsersFieldset',
                'RolesFieldset' => 'SiteUser\Form\RolesFieldset',
                'RoleChildFieldset' => 'SiteUser\Form\RoleChildFieldset',
                'PermissionsFieldset' => 'SiteUser\Form\PermissionsFieldset'
            ]
        ];
    }

    public function getServiceConfig(){
        return [
            'factories' => [
                'SiteUser\Service\UserService'
            ]
        ];
    }
}
