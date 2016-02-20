<?php namespace Investor\Controller;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ViewController extends AbstractActionController implements ServiceLocatorAwareInterface{
    protected $sl;
    protected $service;
    protected $view;

    public function __construct(){
        $this->service = array();
        $this->view    = new ViewModel();
    }

    public function setServiceLocator(ServiceLocatorInterface $sl){
        $this->sl = $sl;
    }

    public function getService($name = 'Investor/InvestorService'){
        if(empty($this->service[$name])){
            $this->service[$name] = $this->sl->get($name);   
        } return $this->service[$name];   
    }

    public function viewInvestmentAction(){
        if(!$this->isGranted('view_investment'))
            return $this->view->setTemplate('error/403');
        
        $u = $this->zfcUserAuthentication()->getIdentity();
        $fs = $this->getService('Financial/FinancialService');
        $summary = $fs->getFinancialSummary();

        return new ViewModel(array(
            'name' => ($u->getDisplayName() ? $u->getDisplayName() : $u->getUsername()),
            'email' => $u->getEmail(),
            'allocations' => $this->getService()->findInvestment($u->getId()),
            'summary' => $summary
        ));
    }

    public function viewAllocationAction(){
        if(!$this->isGranted('view_allocation'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array(
            'allocations' => $this->getService()->findAllAllocations(),
        ));
    }

    public function viewCategoryAction(){
        if(!$this->isGranted('view_allocation_category'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array(
            'categories' => $this->getService()->findAllCategories(),
        ));
    }
}