<?php namespace Application\Navigation\Factory;

use Zend\Navigation\Service\DefaultNavigationFactory;

class AdminNavigationFactory extends DefaultNavigationFactory{
    protected function getName(){
        return 'admin';
    }
}