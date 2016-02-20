<?php namespace Landlord\Factory;

use Landlord\Controller\WriteController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WriteControllerFactory implements FactoryInterface{
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
        $form = $realSL->get('FormElementManager')->get('Landlord\Form\TenantForm');

        return new WriteController($service, $form);
    }
}