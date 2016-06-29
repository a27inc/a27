<?php namespace Property\Factory;

use Property\Controller\SellController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SellControllerFactory implements FactoryInterface{
    /**
     * @param ServiceLocatorInterface $sl
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        return new SellController($sl->getServiceLocator());
    }
}