<?php namespace Financial\Factory;

use Financial\Controller\DeleteController;
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
        $service = $realSL->get('Financial\Service\FinancialService');
        return new DeleteController($service);
    }
}