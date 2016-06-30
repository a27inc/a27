<?php namespace Property\Factory;

use Property\Controller\RentController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RentControllerFactory implements FactoryInterface{
    /**
     * @param ServiceLocatorInterface $sl
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        return new RentController($sl->getServiceLocator());
    }
}