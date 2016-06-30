<?php namespace Application\Navigation\Factory;

use Zend\Navigation\Service\DefaultNavigationFactory;

class InvestorNavigationFactory extends DefaultNavigationFactory{
    protected function getName(){
        return 'investor';
    }
}