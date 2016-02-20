<?php namespace Financial\Factory;

use Financial\Controller\FinancialController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FinancialControllerFactory implements FactoryInterface{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $sl
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        $realSL = $sl->getServiceLocator();
        $fs = $realSL->get('Financial/FinancialService');

        return new FinancialController($fs);
    }
}