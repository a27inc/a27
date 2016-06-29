<?php namespace Investor\Controller;

use Application\Controller\AbstractController;

class ViewController extends AbstractController{
    protected $defaultService = 'Investor/InvestorService';

    public function viewInvestorAction(){
        if(!$this->isGranted('view_investor'))
            return $this->view->setTemplate('error/403');

        return $this->view->setVariables(array(
            'investors' => $this->getService()->findAllInvestors(),
        ));  
    }
    
    public function viewAllocationAction(){
        if(!$this->isGranted('view_allocation'))
            return $this->view->setTemplate('error/403');

        return $this->view->setVariables(array(
            'allocations' => $this->getService()->findAllAllocations(),
        ));
    }

    public function viewCategoryAction(){
        if(!$this->isGranted('view_allocation_category'))
            return $this->view->setTemplate('error/403');

        return $this->view->setVariables(array(
            'categories' => $this->getService()->findAllCategories(),
        ));
    }

    public function viewInvestmentAction(){
        if(!$this->isGranted('view_investment'))
            return $this->view->setTemplate('error/403');
        
        $u = $this->zfcUserAuthentication()->getIdentity();
        $fs = $this->getService('Financial/FinancialService');
        $summary = $fs->getFinancialSummary();
        
        return $this->view->setVariables(array(
            'name' => ($u->getDisplayName() ? $u->getDisplayName() : $u->getUsername()),
            'email' => $u->getEmail(),
            'allocations' => $this->getService()->findInvestment($u->getId()),
            'summary' => $summary ?: array()
        ));
    }

    public function viewProfileAction(){
        if(!$this->isGranted('view_investment'))
            return $this->view->setTemplate('error/403');
        
        $u = $this->zfcUserAuthentication()->getIdentity();

        return $this->view->setVariables(array(
            'name' => ($u->getDisplayName() ? $u->getDisplayName() : $u->getUsername()),
            'email' => $u->getEmail()
        ));
    }
}