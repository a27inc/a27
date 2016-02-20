<?php namespace Demo\Factory;

use Demo\Controller\WriteController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WriteControllerFactory implements FactoryInterface{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $sl
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $sl){
        
        $realSL = $sl->getServiceLocator();
        $service = $realSL->get('Demo/DemoService');
        $form = $realSL->get('FormElementManager')->get('Demo\Form\PersonForm');

        return new WriteController($service, $form);
    }
}