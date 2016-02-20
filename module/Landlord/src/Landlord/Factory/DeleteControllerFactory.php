<?php namespace Landlord\Factory;

use Landlord\Controller\DeleteController;
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
        $service = $realSL->get('Landlord/LandlordService');
        return new DeleteController($service);
    }
}