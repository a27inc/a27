<?php namespace Demo\Factory;

use Demo\Controller\PersonController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PersonControllerFactory implements FactoryInterface{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $sl
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        $realSL = $sl->getServiceLocator();
        $service = $realSL->get('Demo/DemoService');

        return new PersonController($service);
    }
}