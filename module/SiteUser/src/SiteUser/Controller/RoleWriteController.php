<?php namespace SiteUser\Controller;

use SiteUser\Service\UserServiceAwareInterface;
use SiteUser\Entity\Role;
use SiteUser\Service\UserService;
use SiteUser\Form\PermissionForm;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleWriteController extends AbstractActionController implements UserServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setUserService(UserService $us){
        $this->service = $us;
    }

    public function addRoleAction(){
        if(!$this->isGranted('add_role'))
            return $this->view->setTemplate('error/403');

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('RoleForm');

        $request = $this->getRequest();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->service->saveRole($form->getData());
                    return $this->redirect()->toRoute('role');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function addPermissionAction(){
        if(!$this->isGranted('add_permission'))
            return $this->view->setTemplate('error/403');

        $form = new PermissionForm();

        $request = $this->getRequest();
        if($request->isPost()){           
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->service->savePermission($form->getData());
                    return $this->redirect()->toRoute('permission');
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
        if(!$this->isGranted('edit_role'))
            return $this->view->setTemplate('error/403');

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('role');

        $role = $this->service->findRole($id);
        //var_dump($role); die;

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('RoleForm');
        $form->bind($role);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->saveRole($form->getData());
                    return $this->redirect()->toRoute('role');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }

    public function editPermissionAction(){
        if(!$this->isGranted('edit_permission'))
            return $this->view->setTemplate('error/403');

        if(!$id = (int) $this->params()->fromRoute('id', 0))
            return $this->redirect()->toRoute('permission');

        $permission = $this->service->findPermission($id);
        //var_dump($permission); die;

        $form = new PermissionForm();
        $form->bind($permission);
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                try{
                    $this->service->savePermission($form->getData());
                    return $this->redirect()->toRoute('permission');
                } catch(\Exception $e){
                    var_dump($e);
                }
            }
        } return new ViewModel(array('form' => $form)); 
    }
}