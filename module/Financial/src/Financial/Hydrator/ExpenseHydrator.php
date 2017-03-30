<?php namespace Financial\Hydrator;

use Application\Hydrator\HydratorAbstract;
use Property\Hydrator\PropertyStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\Hydrator\NamingStrategy\CompositeNamingStrategy;
use Zend\Hydrator\NamingStrategy\UnderscoreNamingStrategy;

class ExpenseHydrator extends HydratorAbstract{

    protected function initHydrate() {
        $this->entityTableMap = array(
            '\Property\Entity\Property'     => 'properties',
            '\Financial\Entity\Category'    => 'financialCategories',
            '\Financial\Entity\Rate'        => 'rates'
        );    
    }
    
    protected function initExtract() {
        $namingMap = new MapNamingStrategy([
            'property_id'   => 'property',
            'category_id'   => 'category',
            'rate_id'       => 'rate'
        ]);
        $underscore = new UnderscoreNamingStrategy();
        $namingStrategies = new CompositeNamingStrategy([
            'property'  => $namingMap,
            'category'  => $namingMap,
            'rate'      => $namingMap,
            'authorId'  => $underscore,
            'dateFiled' => $underscore,
            'dateFrom'  => $underscore,
            'dateTo'    => $underscore
        ]); 
        
        $this->setNamingStrategy($namingStrategies);
        $this->addStrategy('property_id', new PropertyStrategy());
        $this->addStrategy('category_id', new CategoryStrategy());
        $this->addStrategy('rate_id', new RateStrategy());
    }
}