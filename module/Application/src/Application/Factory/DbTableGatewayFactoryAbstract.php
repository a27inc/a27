<?php namespace Application\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;

class DbTableGatewayFactoryAbstract implements AbstractFactoryInterface{
    
    public function canCreateServiceWithName(ServiceLocatorInterface $sl, $name, $requestedName){
        return fnmatch('*DbTableGateway', $requestedName) && preg_match('/^[_a-z]+$/', str_replace('DbTableGateway', '', $requestedName));
    }

    public function createServiceWithName(ServiceLocatorInterface $sl, $name, $requestedName){
        $adapter = $sl->get('Zend\Db\Adapter\Adapter');
        $table = str_replace('DbTableGateway', '', $requestedName);
        return new TableGateway($table, $adapter);
    }
}