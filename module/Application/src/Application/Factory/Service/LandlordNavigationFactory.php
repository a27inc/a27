<?php namespace Application\Factory\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class LandlordNavigationFactory extends DefaultNavigationFactory{
    protected function getName(){
        return 'landlord';
    }
}