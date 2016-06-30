<?php namespace Property\Controller;

use Property\Service\PropertyServiceAwareInterface;
use Property\Service\PropertyService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeleteController extends AbstractActionController implements PropertyServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setPropertyService(PropertyService $s){
        $this->service = $s;
    }

    public function deleteAction(){
        if(!$this->isGranted('delete_property'))
            return $this->view->setTemplate('error/403');

        try{
            $property = $this->service->find($this->params('id'));
        } catch(\InvalidArgumentException $e){
            return $this->redirect()->toRoute('property');
        }

        $request = $this->getRequest();

        if($request->isPost()){
            $del = $request->getPost('delete_confirmation', 'no');

            if($del === 'yes') {
                $this->service->delete($property);
            } return $this->redirect()->toRoute('property');
        }

        return new ViewModel(array(
            'property' => $property
        ));
    }
}