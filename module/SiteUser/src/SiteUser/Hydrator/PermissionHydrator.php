<?php namespace SiteUser\Hydrator;

use Application\Hydrator\HydratorAbstract;
use Zend\Hydrator\NamingStrategy\CompositeNamingStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class PermissionHydrator extends HydratorAbstract{
    
    protected function initExtract() {
        $namingMap = new MapNamingStrategy([
           'permission_name'   => 'name']);
       $namingStrategies = new CompositeNamingStrategy([
           'name'  => $namingMap,]);
       $this->setNamingStrategy($namingStrategies);
    }
}