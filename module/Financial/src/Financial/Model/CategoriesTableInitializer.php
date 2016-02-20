<?php namespace Financial\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CategoriesTableInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof CategoriesTableAwareInterface){
            $ct = $sl->getServiceLocator()->get('Financial/CategoriesTable');
            $instance->setCategoriesTable($ct);
        }
    }
}