<?php namespace Property\Service;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PropertyServiceInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof PropertyServiceAwareInterface){
            $ps = $sl->getServiceLocator()->get('Property/PropertyService');
            $instance->setPropertyService($ps);
        }
    }
}