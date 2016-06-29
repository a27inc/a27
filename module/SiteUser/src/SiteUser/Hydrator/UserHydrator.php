<?php namespace SiteUser\Hydrator;

use Application\Hydrator\HydratorAbstract;
use Zend\Hydrator\Filter\FilterComposite;
use Zend\Hydrator\Filter\MethodMatchFilter;
use Zend\Hydrator\NamingStrategy\CompositeNamingStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class UserHydrator extends HydratorAbstract{

    protected function initHydrate() {
        $this->entityTableMap = array(
            '\SiteUser\Entity\Role' => 'roles'
        );
        
        $this->entitySetterMap = array(
            'Role' => 'add'  
        );
    }
    
    protected function initExtract() {
        $exclude = new FilterComposite();
        $exclude->addFilter('roleIds', new MethodMatchFilter('roleIds'), FilterComposite::CONDITION_AND);
        $this->filterComposite->addFilter('excludes', $exclude, FilterComposite::CONDITION_AND);

        $namingMap = new MapNamingStrategy([
            'displayName'   => 'displayName']);
        $namingStrategies = new CompositeNamingStrategy([
            'displayName'  => $namingMap]);
        $this->setNamingStrategy($namingStrategies);
    }
}