<?php namespace Landlord\Factory;

use Landlord\Controller\TenantController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TenantControllerFactory implements FactoryInterface{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $sl
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        $realSL = $sl->getServiceLocator();
        $service = $realSL->get('Landlord/LandlordService');

        return new TenantController($service);
    }
}