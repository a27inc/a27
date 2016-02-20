<?php namespace SiteUser\Controller;

use SiteUser\Service\UserServiceAwareInterface;
use SiteUser\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleDeleteController extends AbstractActionController implements UserServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setUserService(UserService $us){
        $this->service = $us;
    }

    public function deleteAction(){
        if(!$this->isGranted('delete_role'))
            return $this->view->setTemplate('error/403');

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('role');
        $entity = $this->service->findRole($id);

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteRole($entity);
            return $this->redirect()->toRoute('role');
        }
        return array('role' => $entity); 
    }
}