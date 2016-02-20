<?php namespace Landlord\Controller;

use Landlord\Service\LandlordServiceAwareInterface;
use Landlord\Service\LandlordService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TenantController extends AbstractActionController implements LandlordServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view = new ViewModel();
    }

    public function setLandlordService(LandlordService $s){
        $this->service = $s;
    }

    public function indexAction(){
        if(!$this->isGranted('view_tenant'))
            return $this->view->setTemplate('error/403'); 

        return new ViewModel(array(
            'tenants' => $this->service->findAll(),
        ));
    }
}