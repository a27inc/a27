<?php namespace Investor\Service;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvestorServiceInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof InvestorServiceAwareInterface){
            $s = $sl->getServiceLocator()->get('Investor/InvestorService');
            $instance->setInvestorService($s);
        }
    }
}