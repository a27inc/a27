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

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('financial/category');

        $category = $this->service->getCategory($id);
        //var_dump($category->toArray()); die;
        $form = new CategoryForm();
        $form->bind($category);
        //var_dump($this->form); die;
        
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

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('financial/expense');

        $expense = $this->service->getExpense($id);
        //var_dump($expense); die;

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('ExpenseForm');
        $form->bind($expense);
        
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

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('financial/income');

        $income = $this->service->getIncome($id);
        //var_dump($expense); die;

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('IncomeForm');
        $form->bind($income);
        
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