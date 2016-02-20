<?php namespace Demo\Factory;

use Demo\Service\DemoService;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DemoServiceFactory implements FactoryInterface{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $sl
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        return new DemoService(
            $sl->get('Zend\Db\Adapter\Adapter'),
            new ClassMethods(FALSE));
    }
}