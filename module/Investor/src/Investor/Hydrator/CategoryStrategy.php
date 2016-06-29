<?php namespace Investor\Hydrator;

use Zend\Hydrator\Strategy\StrategyInterface;
use Investor\Entity\Category;

class CategoryStrategy implements StrategyInterface{
    
    public function extract($value) {
        if ($value instanceof Category && !empty($value->getId())) {
            return $value->getId();
        }
    }
    
    public function hydrate($value) {

    }
}