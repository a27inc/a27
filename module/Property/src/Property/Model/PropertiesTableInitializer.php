<?php namespace Property\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PropertiesTableInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof PropertiesTableAwareInterface){
            $pt = $sl->getServiceLocator()->get('Property/PropertiesTable');
            $instance->setPropertiesTable($pt);
        }
    }
}