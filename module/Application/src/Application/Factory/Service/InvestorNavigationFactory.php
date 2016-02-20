<?php namespace Application\Factory\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class InvestorNavigationFactory extends DefaultNavigationFactory{
    protected function getName(){
        return 'investor';
    }
}