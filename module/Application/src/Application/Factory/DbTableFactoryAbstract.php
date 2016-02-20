<?php namespace Application\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbTableFactoryAbstract implements AbstractFactoryInterface{
    
    public function canCreateServiceWithName(ServiceLocatorInterface $sl, $name, $requestedName){
        return fnmatch('*Table', $requestedName) && preg_match('/^[a-zA-Z]+\/[a-zA-Z]+$/', $requestedName);
    }

    public function createServiceWithName(ServiceLocatorInterface $sl, $name, $requestedName){
        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
        $parts = explode('/', $requestedName);
        $class = ucfirst($parts[0]).'\\Model\\'.ucfirst($parts[1]);
        return new $class($adapter);
    }
}