<?php namespace SiteUser\Hydrator;

use Zend\Hydrator\Strategy\StrategyInterface;
use SiteUser\Entity\User;

class UserStrategy implements StrategyInterface{
    
    public function extract($value) {
        if ($value instanceof User && !empty($value->getId())) {
            return $value->getId();
        }
    }
    
    public function hydrate($value) {

    }
}