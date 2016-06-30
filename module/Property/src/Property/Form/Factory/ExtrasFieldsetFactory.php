<?php namespace Property\Form\Factory;

use Property\Form\ExtrasFieldset;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class ExtrasFieldsetFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $sl) {
        $extras = $sl->getServiceLocator()->get('Property/ExtrasTable');
        return new ExtrasFieldset($extras);
    }
}

