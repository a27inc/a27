<?php namespace SiteUser\Controller;

use SiteUser\Service\UserServiceAwareInterface;
use SiteUser\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserWriteController extends AbstractActionController implements UserServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setUserService(UserService $us){
        $this->service = $us;
    }

    public function editAction(){
        if(!$this->isGranted('edit_user'))
            return $this->view->setTemplate('error/403');

        if(!$this->zfcUserAuthentication()->hasIdentity())
            return $this->redirect()->toRoute('zfcuser/login'); 

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->service->findUser($id))
            return $this->redirect()->toRoute('site-user');

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('UserForm');
        $form->bind($entity);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveUser($form->getData());
                    return $this->redirect()->toRoute('site-user');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }
}