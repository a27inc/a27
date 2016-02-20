<?php namespace SiteUser\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsersTableInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof UsersTableAwareInterface){
            $ut = $sl->getServiceLocator()->get('SiteUser/UsersTable');
            $instance->setUsersTable($ut);
        }
    }
}