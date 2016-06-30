<?php namespace Property\Factory;

use Property\Controller\PropertyController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PropertyControllerFactory implements FactoryInterface{
    /**
     * @param ServiceLocatorInterface $sl
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        return new PropertyController($sl->getServiceLocator());
    }
}