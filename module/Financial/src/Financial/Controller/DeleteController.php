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
        if(!$this->isGranted('delete_expense'))
            return $this->view->setTemplate('error/403');

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('financial/expense');
        $entity = $this->service->getExpense($id);

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteExpense($entity);
            return $this->redirect()->toRoute('financial/expense');
        }
        return array('expense' => $entity); 
    }

    public function deleteIncomeAction(){ 
        if(!$this->isGranted('delete_income'))
            return $this->view->setTemplate('error/403');

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('financial/income');
        $entity = $this->service->getIncome($id);

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

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('financial/category');
        $entity = $this->service->getCategory($id);

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteCategory($entity);
            return $this->redirect()->toRoute('financial/category');
        }
        return array('category' => $entity); 
    }
}