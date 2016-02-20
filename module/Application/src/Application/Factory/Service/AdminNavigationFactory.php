<?php namespace Application\Factory\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class AdminNavigationFactory extends DefaultNavigationFactory{
    protected function getName(){
        return 'admin';
    }
}