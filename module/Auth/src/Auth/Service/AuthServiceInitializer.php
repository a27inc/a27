<?php namespace Auth\Service;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthServiceInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof AuthServiceAwareInterface){
            $s = $sl->get('zfcuser_auth_service');
            $instance->setAuthService($s);
        }
    }
}