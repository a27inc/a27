<?php namespace Property\Controller;

use Property\Service\PropertyServiceAwareInterface;
use Property\Service\PropertyService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PropertyController extends AbstractActionController implements PropertyServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setPropertyService(PropertyService $s){
        $this->service = $s;
    }

    public function indexAction(){
        if(!$this->isGranted('view_property'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array('properties' => $this->service->findAll()));
    }
}