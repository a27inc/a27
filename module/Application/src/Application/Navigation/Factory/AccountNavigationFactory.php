<?php namespace Application\Navigation\Factory;

use Zend\Navigation\Service\DefaultNavigationFactory;

class AccountNavigationFactory extends DefaultNavigationFactory{
    protected function getName(){
        return 'account';
    }
}