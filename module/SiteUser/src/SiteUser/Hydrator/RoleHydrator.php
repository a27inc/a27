<?php namespace SiteUser\Hydrator;

use Application\Hydrator\HydratorAbstract;
use SiteUser\Entity\Role;
use Zend\Hydrator\Filter\FilterComposite;
use Zend\Hydrator\Filter\MethodMatchFilter;
use Zend\Hydrator\NamingStrategy\CompositeNamingStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class RoleHydrator extends HydratorAbstract{

    protected function initHydrate() {
        $this->entityTableMap = array(
            '\SiteUser\Entity\Permission'   => 'permissions'
        );
        
        $this->entitySetterMap = array(
            'Permission'    => 'add'
        );
    }
    
    protected function initExtract() {
        $namingMap = new MapNamingStrategy([
            'role_name'   => 'name']);
        $namingStrategies = new CompositeNamingStrategy([
            'name'  => $namingMap]);
        $this->setNamingStrategy($namingStrategies);

        $exclude = new FilterComposite();
        $exclude->addFilter('childId', new MethodMatchFilter('getChildId'), FilterComposite::CONDITION_AND);
        $exclude->addFilter('parentId', new MethodMatchFilter('getParentId'), FilterComposite::CONDITION_AND);
        $exclude->addFilter('permissionIds', new MethodMatchFilter('getPermissionIds'), FilterComposite::CONDITION_AND);
        $exclude->addFilter('permissionNames', new MethodMatchFilter('getPermissionNames'), FilterComposite::CONDITION_AND);
        $this->filterComposite->addFilter('excludes', $exclude, FilterComposite::CONDITION_AND);
    }
}