<?php namespace Financial\Factory;

use Financial\Service\FinancialService;
use Zend\Hydrator\ObjectProperty;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FinancialServiceFactory implements FactoryInterface{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $sl
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        return new FinancialService(
            $sl->get('Zend\Db\Adapter\Adapter'),
            new ObjectProperty());
    }
}