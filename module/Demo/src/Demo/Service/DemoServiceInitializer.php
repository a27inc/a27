<?php namespace Demo\Service;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DemoServiceInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof DemoServiceAwareInterface){
            $s = $sl->getServiceLocator()->get('Demo/DemoService');
            $instance->setDemoService($s);
        }
    }
}