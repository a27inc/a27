<?php namespace Property\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExtrasTableInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof ExtrasTableAwareInterface){
            $t = $sl->getServiceLocator()->get('Property/ExtrasTable');
            $instance->setExtrasTable($t);
        }
    }
}