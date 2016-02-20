<?php namespace SiteUser\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RolesTableInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof RolesTableAwareInterface){
            $rt = $sl->getServiceLocator()->get('SiteUser/RolesTable');
            $instance->setRolesTable($rt);
        }
    }
}