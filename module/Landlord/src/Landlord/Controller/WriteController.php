<?php namespace Landlord\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class WriteController extends AbstractController{

    protected $defaultService = 'Landlord/LandlordService';
    protected $defaultForm = 'TenantForm';

    public function addAction(){
        if(!$this->isGranted('add_tenant'))
            return $this->view->setTemplate('error/403');

        $request = $this->getRequest();
        $form = $this->getForm();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->getService()->saveTenant($form->getData());
                    return $this->redirect()->toRoute('tenant');
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
        if(!$this->isGranted('edit_tenant'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->getService()->find($id))
            return $this->redirect()->toRoute('tenant');
        
        $form = $this->getForm();
        $form->bind($entity);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->getService()->saveTenant($form->getData());
                    return $this->redirect()->toRoute('tenant');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }
}