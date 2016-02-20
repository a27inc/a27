<?php namespace Landlord\Factory;

use Landlord\Service\LandlordService;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LandlordServiceFactory implements FactoryInterface{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $sl
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        return new LandlordService(
            $sl->get('Zend\Db\Adapter\Adapter'),
            new ClassMethods(FALSE));
    }
}