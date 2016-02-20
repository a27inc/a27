<?php namespace Demo\Controller;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Demo\Service\DemoService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WriteController extends AbstractActionController implements ServiceLocatorAwareInterface{
    protected $service;
    protected $view;
    protected $form;

    public function setServiceLocator(ServiceLocatorInterface $sl){
        $this->sl = $sl;
    }

    public function getService(){
        if(is_null($this->service)){
            $this->service = $this->sl->get('Demo/DemoService');   
        } return $this->service;   
    }

    public function getForm(){
        if(is_null($this->form)){
            $fm = $this->sl->get('FormElementManager');
            $this->form = $fm->get('Demo\Form\PersonForm');   
        } return $this->form;
    }

    public function addAction(){
        if(!$this->isGranted('add_person'))
            return $this->view->setTemplate('error/403');

        $request = $this->getRequest();
        $form = $this->getForm();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->getService()->save($form->getData());
                    return $this->redirect()->toRoute('person');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function editAction(){
        if(!$this->isGranted('edit_person'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id) return $this->redirect()->toRoute('person');

        $entity = $this->getService()->find($id);
        $form = $this->getForm();
        $form->bind($entity);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->getService()->save($form->getData());
                    return $this->redirect()->toRoute('person');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }
}