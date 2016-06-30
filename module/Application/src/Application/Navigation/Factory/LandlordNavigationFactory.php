<?php namespace Application\Navigation\Factory;

use Zend\Navigation\Service\DefaultNavigationFactory;

class LandlordNavigationFactory extends DefaultNavigationFactory{
    protected function getName(){
        return 'landlord';
    }
}