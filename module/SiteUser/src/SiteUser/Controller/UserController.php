<?php namespace SiteUser\Controller;

use SiteUser\Service\UserServiceAwareInterface;
use SiteUser\Service\UserService;
use SiteUser\Entity\UserRole;
use SiteUser\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController implements UserServiceAwareInterface{
    const ROUTE_CHANGEPASSWD = 'zfcuser/changepassword';
    const ROUTE_LOGIN        = 'zfcuser/login';
    const ROUTE_REGISTER     = 'zfcuser/register';
    const ROUTE_CHANGEEMAIL  = 'zfcuser/changeemail';

    const USER_STATE_ACTIVE     = 1;
    const USER_STATE_APPROVED   = 2;

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

    public function profileAction(){
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }

        $user = $this->zfcUserAuthentication()->getIdentity();
        $displayMsg = false;
        // approve and assign super admin role for the first user
        if ($user->getState() == static::USER_STATE_ACTIVE && $user->getId() == 1) {
            $siteUser = $this->service->findUser($user->getId());
            $this->service->saveUser(
                $siteUser->setState(static::USER_STATE_APPROVED));
            $this->service->addUserRole($siteUser->getId(), 9);
            $this->redirect()->toRoute('site-user/profile');
        }
        else if($user->getState() == static::USER_STATE_ACTIVE) {
            $config = $this->getServiceLocator()->get('config');
            $admin = isset($config['site']['admin'])
                ? $config['site']['admin']
                : array('name' => 'the site administrator');
            
            $displayMsg = 'NO ACCESS GRANTED: To complete your registration, please contact ';
            if (!empty($admin['name'])) {
                $displayMsg .= $admin['name'];
            }
            else {
                $displayMsg .= 'the site administration';   
            }
            
            if (!empty($admin['email'])) {
                $displayMsg .= ' via email at '.$admin['email'];
            }
            
            if (!empty($admin['phone'])) {
                $displayMsg .= (empty($admin['email']) ? ' ' : ' or '). 'via phone at '.$admin['phone'];
            }
        }

        return new ViewModel(array(
            'user' => $user,
            'displayMsg' => $displayMsg,
        ));
    }
}