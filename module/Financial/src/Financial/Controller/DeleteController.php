<?php namespace Financial\Controller;

use Financial\Service\FinancialServiceAwareInterface;
use Financial\Service\FinancialService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeleteController extends AbstractActionController implements FinancialServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setFinancialService(FinancialService $fs){
        $this->service = $fs;
    }

    public function deleteExpenseAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->getExpense($id))
            return $this->redirect()->toRoute('financial/expense');

        if(!$this->isGranted('delete_expense', $entity))
            return $this->view->setTemplate('error/403');
        
        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteExpense($entity);
            return $this->redirect()->toRoute('financial/expense');
        }
        return array('expense' => $entity); 
    }

    public function deleteIncomeAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->getIncome($id))
            return $this->redirect()->toRoute('financial/income');

        if(!$this->isGranted('delete_income', $entity))
            return $this->view->setTemplate('error/403');

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteIncome($entity);
            return $this->redirect()->toRoute('financial/income');
        }
        return array('income' => $entity); 
    }

    public function deleteCategoryAction(){ 
        if(!$this->isGranted('delete_financial_category'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->getCategory($id))
            return $this->redirect()->toRoute('financial/category');

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteCategory($entity);
            return $this->redirect()->toRoute('financial/category');
        }
        return array('category' => $entity); 
    }
}