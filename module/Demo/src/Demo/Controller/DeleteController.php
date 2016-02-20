<?php namespace Demo\Controller;

use Demo\Service\DemoServiceAwareInterface;
use Demo\Service\DemoService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeleteController extends AbstractActionController implements DemoServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view = new ViewModel();
    }

    public function setDemoService(DemoService $s){
        $this->service = $s;
    }

    public function deleteAction(){
        if(!$this->isGranted('delete_person'))
            return $this->view->setTemplate('error/403'); 
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id) 
            return $this->redirect()->toRoute('person');
        $entity = $this->service->find($id);

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->delete($entity);
            
            return $this->redirect()->toRoute('person');
        }
        return array('person' => $entity); 
    }
}