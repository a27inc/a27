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
                    return $this->redirect()->toRoute('allocation');
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
                    return $this->redirect()->toRoute('allocation/category');
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

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('allocation');

        $allocation = $this->service->findAllocation($id);
        //var_dump($allocation); die;

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Investor\Form\AllocationForm');
        $form->bind($allocation);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveAllocation($form->getData());
                    return $this->redirect()->toRoute('allocation');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }

    public function editCategoryAction(){
        if(!$this->isGranted('edit_allocation_category'))
            return $this->view->setTemplate('error/403');

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('allocation/category');

        $category = $this->service->findCategory($id);
        //var_dump($category); die;

        $form = new CategoryForm();
        $form->bind($category);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveCategory($form->getData());
                    return $this->redirect()->toRoute('allocation/category');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }
}