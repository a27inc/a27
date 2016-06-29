<?php namespace Landlord\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class TenantController extends AbstractController{

    protected $defaultService = 'Landlord/LandlordService';

    public function indexAction(){
        if(!$this->isGranted('view_tenant'))
            return $this->view->setTemplate('error/403'); 

        return new ViewModel(array(
            'tenants' => $this->getService()->findAll(),
        ));
    }
}