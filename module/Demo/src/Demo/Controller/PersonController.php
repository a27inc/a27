<?php namespace Demo\Controller;

use Demo\Service\DemoServiceAwareInterface;
use Demo\Service\DemoService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PersonController extends AbstractActionController implements DemoServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view = new ViewModel();
    }

    public function setDemoService(DemoService $s){
        $this->service = $s;
    }

    public function indexAction(){
        if(!$this->isGranted('view_person'))
            return $this->view->setTemplate('error/403'); 

        return new ViewModel(array(
            'persons' => $this->service->findAll(),
        ));
    }
}