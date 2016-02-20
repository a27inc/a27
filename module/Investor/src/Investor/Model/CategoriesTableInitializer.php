<?php namespace Investor\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CategoriesTableInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof InvestorCategoriesTableAwareInterface){
            $ct = $sl->getServiceLocator()->get('Investor/CategoriesTable');
            $instance->setCategoriesTable($ct);
        }
    }
}