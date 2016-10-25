<?php namespace Landlord\Controller;

use Application\Controller\AbstractController;

class DeleteController extends AbstractController{

    protected $defaultService = 'Landlord/LandlordService';

    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->getService()->find($id)) 
            return $this->redirect()->toRoute('tenant');

        if(!$this->isGranted('delete_tenant', $entity))
            return $this->view->setTemplate('error/403');

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->getService()->deleteTenant($entity);
            
            return $this->redirect()->toRoute('tenant');
        }
        return array('tenant' => $entity); 
    }
}