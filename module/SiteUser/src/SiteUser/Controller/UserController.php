<?php namespace SiteUser\Controller;

use SiteUser\Service\UserServiceAwareInterface;
use SiteUser\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController implements UserServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setUserService(UserService $us){
        $this->service = $us;
    }

    public function indexAction(){
        if(!$this->isGranted('view_user'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array(
            'users' => $this->service->findAllUsers(),
        ));
    }
}