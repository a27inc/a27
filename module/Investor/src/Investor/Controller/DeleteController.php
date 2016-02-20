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

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('allocation');
        $entity = $this->service->findAllocation($id);

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteAllocation($entity);
            return $this->redirect()->toRoute('allocation');
        }
        return array('allocation' => $entity); 
    }

    public function deleteCategoryAction(){
        if(!$this->isGranted('delete_allocation_category'))
            return $this->view->setTemplate('error/403');

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('allocation/category');
        $entity = $this->service->findCategory($id);

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteCategory($entity);
            return $this->redirect()->toRoute('allocation/category');
        }
        return array('category' => $entity); 
    }
}