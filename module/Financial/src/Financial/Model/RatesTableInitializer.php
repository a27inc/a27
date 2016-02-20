<?php namespace Financial\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RatesTableInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof RatesTableAwareInterface){
            $rt = $sl->getServiceLocator()->get('Financial/RatesTable');
            $instance->setRatesTable($rt);
        }
    }
}