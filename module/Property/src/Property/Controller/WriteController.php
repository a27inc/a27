<?php namespace Property\Controller;

use Application\Controller\AbstractController;
use Property\Entity\Image;
use Zend\Http\PhpEnvironment\Response;

class WriteController extends AbstractController{

    protected $defaultService = 'Property/PropertyService';
    protected $defaultForm = 'PropertyForm';


    public function addAction(){
        if(!$this->isGranted('add_property'))
            return $this->view->setTemplate('error/403');

        $request = $this->getRequest();
        $form = $this->getForm();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                try{
                    $this->getService()->save($form->getData());
                    return $this->redirect()->toRoute('property');
                } catch(\Exception $e){
                     var_dump($e->getMessage());
                     // Some DB Error happened, log it and let the user know
                }
            }
        }

        return $this->view->setVariables(array(
            'form' => $form
        ));
    }

    public function editAction(){
        if(!$this->isGranted('edit_property'))
            return $this->view->setTemplate('error/403');

        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id || !$entity = $this->getService()->find($id))
            return $this->redirect()->toRoute('property');

        $form = $this->getForm();
        $form->setAttribute('action', $this->url('property/edit', array(), true));
        $form->bind($entity);

        $prg = $this->fileprg($form);
        if($prg instanceof Response)
            return $prg; // Return PRG redirect response
        elseif(is_array($prg)){
            if(isset($prg['properties']['images'])){
                // save uploaded files
                $images = $prg['properties']['images'];
                foreach($images as $k => $i){
                    if(isset($i['image_file']) && !$i['image_file']['error']){
                        $file = str_replace(array('public/', '\\'), '/', $i['image_file']['tmp_name']);
                        //$file_name = substr($file, strrpos($file, '/')+1);
                        if(!isset($entity->images[$k]))
                            $entity->images[$k] = new Image();
                        $entity->images[$k]->setFile(substr($file, strrpos($file, '/')+1));
                        $prg['properties']['images'][$k]['file'] = $entity->images[$k]->getFile(); 
                    }
                }
            } $form->setData($prg);
            
            if($form->isValid()){
                try{
                    if($this->getService()->save($entity))
                        return $this->redirect()->toRoute('property');
                } catch (\Exception $e){
                     die($e->getMessage());
                } 
            } 
        }

        $uploaded = array();
        foreach($entity->images as $k => $i)
            if($f = $i->getFile()) $uploaded[$k] = $i->dir.$f;

        return $this->view->setVariables(array(
            'form' => $form,
            'uploaded' => $uploaded
        ));
    }
}