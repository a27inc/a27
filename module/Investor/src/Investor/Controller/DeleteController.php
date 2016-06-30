<?php namespace Investor\Controller;

use Investor\Service\InvestorServiceAwareInterface;
use Investor\Service\InvestorService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeleteController extends AbstractActionController implements InvestorServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setInvestorService(InvestorService $s){
        $this->service = $s;
    }

    public function deleteAllocationAction(){
        if(!$this->isGranted('delete_allocation'))
            return $this->view->setTemplate('error/403');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->findAllocation($id))
            return $this->redirect()->toRoute('investor/allocation');

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteAllocation($entity);
            return $this->redirect()->toRoute('investor/allocation');
        }
        return array('allocation' => $entity); 
    }

    public function deleteCategoryAction(){
        if(!$this->isGranted('delete_allocation_category'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->findCategory($id))
            return $this->redirect()->toRoute('investor/allocation/category');

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteCategory($entity);
            return $this->redirect()->toRoute('investor/allocation/category');
        }
        return array('category' => $entity); 
    }
}