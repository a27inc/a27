<?php namespace Application\Factory\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class AccountNavigationFactory extends DefaultNavigationFactory{
    protected function getName(){
        return 'account';
    }
}