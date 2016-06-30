<?php namespace Property\Hydrator;

use Zend\Hydrator\Strategy\StrategyInterface;
use Property\Entity\Property;

class PropertyStrategy implements StrategyInterface{
    
    public function extract($value) {
        if ($value instanceof Property && !empty($value->getId())) {
            return $value->getId();
        }
    }
    
    public function hydrate($value) {

    }
}