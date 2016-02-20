<?php namespace SiteUser\Service;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserServiceInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof UserServiceAwareInterface){
            $us = $sl->getServiceLocator()->get('SiteUser/UserService');
            $instance->setUserService($us);
        }
    }
}