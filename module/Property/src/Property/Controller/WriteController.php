<?php namespace Property\Controller;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Property\Entity\Property;
use Property\Entity\PropertyInfo;
use Property\Entity\PropertyImage;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WriteController extends AbstractActionController implements ServiceLocatorAwareInterface{
    protected $service;
    protected $view;
    protected $form;
    protected $sl;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setServiceLocator(ServiceLocatorInterface $sl){
        $this->service = array();
        $this->form = array();
        $this->sl = $sl;
    }

    public function getService($name = 'Property/PropertyService'){
        if(empty($this->service[$name])){
            $this->service[$name] = $this->sl->get($name);   
        } return $this->service[$name];   
    }

    public function getForm($name = 'Property\Form\PropertyForm'){
        if(empty($this->form[$name])){
            $fm = $this->sl->get('FormElementManager');
            $this->form[$name] = $fm->get('Property\Form\PropertyForm');   
        } return $this->form[$name];
    }

    public function addAction(){
        if(!$this->isGranted('add_property'))
            return $this->view->setTemplate('error/403');

        $request = $this->getRequest();
        $form = $this->getForm();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->getService()->saveProperty($form->getData());
                    return $this->redirect()->toRoute('property');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                     // Some DB Error happened, log it and let the user know
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function editAction(){
        if(!$this->isGranted('edit_property'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id) return $this->redirect()->toRoute('property');

        $property = $this->getService()->findProperty($id);
        
        $form = $this->getForm();
        $form->setAttribute('action', $this->url('property/edit', array(), true));
        $form->bind($property);

        $prg = $this->fileprg($form);
        if($prg instanceof \Zend\Http\PhpEnvironment\Response)
            return $prg; // Return PRG redirect response
        elseif(is_array($prg)){ 
            
            if(isset($prg['properties']['images'])){
                // save uploaded files
                $images = $prg['properties']['images'];
                foreach($images as $k => $i){
                    if(isset($i['image_file']) && !$i['image_file']['error']){
                        $file = str_replace(array('public/', '\\'), '/', $i['image_file']['tmp_name']);
                        $file_name = substr($file, strrpos($file, '/')+1);
                        if(!isset($property->images[$k]))
                            $property->images[$k] = new PropertyImage();    
                        $property->images[$k]->setFile(substr($file, strrpos($file, '/')+1));
                        $prg['properties']['images'][$k]['file'] = $property->images[$k]->getFile(); 
                    }
                }
            } $form->setData($prg);
            
            if($form->isValid()){
                try{
                    if($this->getService()->saveProperty($property))
                        return $this->redirect()->toRoute('property');
                } catch (\Exception $e){
                     die($e->getMessage());
                } 
            } 
        }

        $uploaded = array();
        foreach($property->images as $k => $i)
            if($f = $i->getFile()) $uploaded[$k] = $i->dir.$f; 

        return new ViewModel(array(
            'form' => $form,
            'uploaded' => $uploaded
        ));
    }

    private function uploadFiles(){
        return new ViewModel(array(
            'form' => $this->getForm()
        ));
    }
}