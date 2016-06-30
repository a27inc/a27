<?php namespace Investor\Hydrator;

use Application\Hydrator\HydratorAbstract;
use Investor\Entity\Allocation;
use Property\Hydrator\PropertyStrategy;
use SiteUser\Hydrator\UserStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\Hydrator\NamingStrategy\CompositeNamingStrategy;

class AllocationHydrator extends HydratorAbstract{

    protected function initHydrate() {
        $this->entityTableMap = array(
            '\Property\Entity\Property'     => 'properties',
            '\Investor\Entity\Category'     => 'allocationCategories',
            '\SiteUser\Entity\User'         => 'user'
        );    
    }
    
    protected function initExtract() {
        $namingMap = new MapNamingStrategy([
            'property_id'   => 'property',
            'category_id'   => 'category',
            'user_id'       => 'user'
        ]);
        $namingStrategies = new CompositeNamingStrategy([
            'property'  => $namingMap,
            'category'  => $namingMap,
            'user'      => $namingMap
        ]); 
        
        $this->setNamingStrategy($namingStrategies);
        $this->addStrategy('property_id', new PropertyStrategy());
        $this->addStrategy('category_id', new CategoryStrategy());
        $this->addStrategy('user_id', new UserStrategy());
    }
}