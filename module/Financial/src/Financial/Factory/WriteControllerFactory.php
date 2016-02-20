<?php namespace Financial\Factory;

use Financial\Controller\WriteController;
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
        $service = $realSL->get('Financial\Service\FinancialService');
        //$exp_form = $realSL->get('FormElementManager')->get('Financial\Form\ExpenseForm');
        //$inc_form = $realSL->get('FormElementManager')->get('Financial\Form\IncomeForm');
        return new WriteController($service);//, $exp_form, $inc_form);
    }
}