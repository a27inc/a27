<?php namespace Financial\Controller;

use Financial\Service\FinancialServiceAwareInterface;
use Financial\Service\FinancialService;
use Financial\Form\CategoryForm;
use Financial\Form\ExpenseForm;
use Financial\Form\IncomeForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WriteController extends AbstractActionController implements FinancialServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view = new ViewModel();
    }

    public function setFinancialService(FinancialService $fs){
        $this->service = $fs;
    }

    public function addCategoryAction(){
        if(!$this->isGranted('add_financial_category'))
            return $this->view->setTemplate('error/403');

        $form = new CategoryForm();
        $request = $this->getRequest();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->service->saveCategory($form->getData());
                    return $this->redirect()->toRoute('financial/category');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));   
    }

    public function editCategoryAction(){
        if(!$this->isGranted('edit_financial_category'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->getCategory($id))
            return $this->redirect()->toRoute('financial/category');
        
        $form = new CategoryForm();
        $form->bind($entity);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveCategory($form->getData());
                    return $this->redirect()->toRoute('financial/category');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form));
    }

    public function addExpenseAction(){
        if(!$this->isGranted('add_expense'))
            return $this->view->setTemplate('error/403');

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('ExpenseForm');
        $request = $this->getRequest();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->service->saveExpense($form->getData());
                    return $this->redirect()->toRoute('financial/expense');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));   
    }

    public function editExpenseAction(){
        if(!$this->isGranted('edit_expense'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->getExpense($id))
            return $this->redirect()->toRoute('financial/expense');
        
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('ExpenseForm');
        $form->bind($entity);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveExpense($form->getData());
                    return $this->redirect()->toRoute('financial/expense');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form));
    }

    public function addIncomeAction(){
        if(!$this->isGranted('add_income'))
            return $this->view->setTemplate('error/403');

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('IncomeForm');
        
        $request = $this->getRequest();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->service->saveIncome($form->getData());
                    return $this->redirect()->toRoute('financial/income');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));    
    }

    public function editIncomeAction(){
        if(!$this->isGranted('edit_income'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->getIncome($id))
            return $this->redirect()->toRoute('financial/income');

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('IncomeForm');
        $form->bind($entity);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveIncome($form->getData());
                    return $this->redirect()->toRoute('financial/income');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form));
    }
}