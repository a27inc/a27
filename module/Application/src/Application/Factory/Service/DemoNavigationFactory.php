<?php namespace Application\Factory\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class DemoNavigationFactory extends DefaultNavigationFactory{
    protected function getName(){
        return 'demo';
    }
}