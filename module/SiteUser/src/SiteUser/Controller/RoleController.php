<?php namespace SiteUser\Controller;

use SiteUser\Service\UserServiceAwareInterface;
use SiteUser\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractActionController implements UserServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setUserService(UserService $us){
        $this->service = $us;
    }

    public function indexAction(){
        if(!$this->isGranted('view_role'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array(
            'roles' => $this->service->findAllRoles(),
        ));
    }

    public function viewRoleAction(){
        if(!$this->isGranted('view_role'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entities = $this->service->findRoleAndChildren($id))
            return $this->redirect()->toRoute('role');

        return new ViewModel(array(
            'roles' => $entities,
            'currentRoleId' => $id
        ));
    }

    public function viewPermissionAction(){
        if(!$this->isGranted('view_permission'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array(
            'permissions' => $this->service->findAllPermissions(),
        ));
    }
}