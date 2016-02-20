<?php namespace Landlord\Controller;

use Landlord\Service\LandlordServiceAwareInterface;
use Landlord\Service\LandlordService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeleteController extends AbstractActionController implements LandlordServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view = new ViewModel();
    }

    public function setLandlordService(LandlordService $s){
        $this->service = $s;
    }

    public function deleteAction(){
        if(!$this->isGranted('delete_tenant'))
            return $this->view->setTemplate('error/403'); 
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id) 
            return $this->redirect()->toRoute('tenant');
        $entity = $this->service->find($id);

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->delete($entity);
            
            return $this->redirect()->toRoute('tenant');
        }
        return array('tenant' => $entity); 
    }
}