<?php namespace Property\Controller;

use Property\Service\PropertyServiceAwareInterface;
use Property\Service\PropertyService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SellController extends AbstractActionController implements PropertyServiceAwareInterface{
    protected $service;

    public function setPropertyService(PropertyService $s){
        $this->service = $s;
    }

    public function indexAction(){
        return new ViewModel(array());
    }

    public function detailsAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $address = (string) $this->params()->fromRoute('address', 0);
        
        if($id != 3 || $address != '1054-Alpug-Ave-Oviedo-FL-32765') 
            return $this->redirect()->toRoute('home');

        return new ViewModel(array());
    }
}