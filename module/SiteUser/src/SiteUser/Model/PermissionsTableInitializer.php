<?php namespace SiteUser\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionsTableInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof PermissionsTableAwareInterface){
            $pt = $sl->getServiceLocator()->get('SiteUser/PermissionsTable');
            $instance->setPermissionsTable($pt);
        }
    }
}