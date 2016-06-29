<?php namespace Application\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbServiceFactoryAbstract implements AbstractFactoryInterface{
    
    public function canCreateServiceWithName(ServiceLocatorInterface $sl, $name, $requestedName){
        return fnmatch('*Service', $requestedName) && preg_match('/^[a-zA-Z]+[\/a-zA-Z]+[a-zA-Z]+$/', $requestedName);
    }

    public function createServiceWithName(ServiceLocatorInterface $sl, $name, $requestedName){
        $parts = explode('/', $requestedName);
        $class = ucfirst($parts[0]).'\\Service\\';
        for($x=1; $x<count($parts)-1; $x++)
            $class .= ucfirst($parts[$x]).'\\';
        $class .= ucfirst($parts[count($parts)-1]);
        return new $class($sl);
    }
}