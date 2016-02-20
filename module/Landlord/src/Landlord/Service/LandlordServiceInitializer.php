<?php namespace Landlord\Service;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LandlordServiceInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof LandlordServiceAwareInterface){
            $s = $sl->getServiceLocator()->get('Landlord/LandlordService');
            $instance->setLandlordService($s);
        }
    }
}