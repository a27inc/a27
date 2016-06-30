<?php namespace Application\Model\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbModelFactoryAbstract implements AbstractFactoryInterface{
    
    public function canCreateServiceWithName(ServiceLocatorInterface $sl, $name, $requestedName){
        return fnmatch('*Model', $requestedName) && preg_match('/^[a-zA-Z]+[\/a-zA-Z]+[a-zA-Z]+$/', $requestedName);
    }

    public function createServiceWithName(ServiceLocatorInterface $sl, $name, $requestedName){
        $parts = explode('/', $requestedName);
        $class = ucfirst($parts[0]).'\\Model\\';
        for($x=1; $x<count($parts)-1; $x++)
            $class .= ucfirst($parts[$x]).'\\';
        $class .= ucfirst(str_replace('Model', '', $parts[count($parts)-1]));
        return new $class();
    }
}