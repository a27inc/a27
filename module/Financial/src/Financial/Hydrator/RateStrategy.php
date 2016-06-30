<?php namespace Financial\Hydrator;

use Zend\Hydrator\Strategy\StrategyInterface;
use Financial\Entity\Rate;

class RateStrategy implements StrategyInterface{
    
    public function extract($value) {
        if ($value instanceof Rate && !empty($value->getId())) {
            return $value->getId();
        }
    }
    
    public function hydrate($value) {

    }
}