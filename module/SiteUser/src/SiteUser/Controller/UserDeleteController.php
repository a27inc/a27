<?php namespace SiteUser\Controller;

use SiteUser\Service\UserServiceAwareInterface;
use SiteUser\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserDeleteController extends AbstractActionController implements UserServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setUserService(UserService $us){
        $this->service = $us;
    }

    public function deleteAction(){    
        if(!$this->isGranted('delete_user'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id) return $this->redirect()->toRoute('site-user');
        $entity = $this->service->findUser($id);

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del');
            if($del == 'Yes') $this->service->deleteUser($entity);
            return $this->redirect()->toRoute('site-user');
        }
        return array('user' => $entity); 
    }
}