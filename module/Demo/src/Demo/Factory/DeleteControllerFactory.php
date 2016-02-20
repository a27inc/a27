<?php namespace Demo\Factory;

use Demo\Controller\DeleteController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeleteControllerFactory implements FactoryInterface{
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
        return new DeleteController($service);
    }
}