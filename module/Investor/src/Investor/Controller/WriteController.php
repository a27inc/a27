<?php namespace Investor\Controller;

use Investor\Service\InvestorServiceAwareInterface;
use Investor\Entity\Category;
use Investor\Service\InvestorService;
use Investor\Form\CategoryForm;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WriteController extends AbstractActionController implements InvestorServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setInvestorService(InvestorService $s){
        $this->service = $s;
    }

    public function addAllocationAction(){
        if(!$this->isGranted('add_allocation'))
            return $this->view->setTemplate('error/403');

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Investor\Form\AllocationForm');

        $request = $this->getRequest();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->service->saveAllocation($form->getData());
                    return $this->redirect()->toRoute('investor/allocation');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function addCategoryAction(){
        if(!$this->isGranted('add_allocation_category'))
            return $this->view->setTemplate('error/403');

        $form = new CategoryForm();

        $request = $this->getRequest();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->service->saveCategory($form->getData());
                    return $this->redirect()->toRoute('investor/allocation/category');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function addInvestorAction(){
        if(!$this->isGranted('add_investor'))
            return $this->view->setTemplate('error/403');

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Investor\Form\InvestorForm');

        $request = $this->getRequest();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->service->saveInvestor($form->getData());
                    return $this->redirect()->toRoute('investor');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function editAllocationAction(){
        if(!$this->isGranted('edit_allocation'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->findAllocation($id))
            return $this->redirect()->toRoute('investor/allocation');

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Investor\Form\AllocationForm');
        $form->bind($entity);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveAllocation($form->getData());
                    return $this->redirect()->toRoute('investor/allocation');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }

    public function editCategoryAction(){
        if(!$this->isGranted('edit_allocation_category'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->findCategory($id))
            return $this->redirect()->toRoute('investor/allocation/category');

        $form = new CategoryForm();
        $form->bind($entity);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveCategory($form->getData());
                    return $this->redirect()->toRoute('investor/allocation/category');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }

    public function editInvestorAction(){
        if(!$this->isGranted('edit_investor'))
            return $this->view->setTemplate('error/403');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->findInvestor($id))
            return $this->redirect()->toRoute('investor');

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Investor\Form\InvestorForm');
        $form->bind($entity);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveInvestor($form->getData());
                    return $this->redirect()->toRoute('investor');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }
}