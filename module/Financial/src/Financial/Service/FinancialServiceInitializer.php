<?php namespace Financial\Service;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FinancialServiceInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof FinancialServiceAwareInterface){
            $fs = $sl->getServiceLocator()->get('Financial/FinancialService');
            $instance->setFinancialService($fs);
        }
    }
}