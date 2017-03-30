<?php namespace Property\Service;

use Application\Service\ServiceAbstract;

use Property\Entity\Info;
use Property\Entity\Property;
use Property\Entity\Image;
use Property\Entity\RentalListing;
use Property\Entity\SaleListing;

use \Imagine\Gd\Imagine;
use \Imagine\Image\Box;
use \Imagine\Image\Point;

use Property\Hydrator\PropertyHydrator;
use Zend\Db\Sql\Predicate\In;
use Zend\Hydrator\ObjectProperty;

class PropertyService extends ServiceAbstract{

    protected $isInsert = false;

    /**
     * Return a single Property
     *
     * @param  int $id Identifier of the Property to be returned
     * @param bool $includeImages with images
     * @return Property
     */
    public function find($id, $includeImages = false){
        $model = $this->getModel('Property/Property');
        //die(var_dump($model->open('id', 1, 100)));
        $property = $model->open('id', $id, 100);
        if ($property && $includeImages) {
            $property->images = $this->getImagesByProperty($property->getId());
        }
        return $property;
    }

    /**
     * Return a set of all Properties that we can iterate over. Single entries of the
     * array are \Property\Entity\Property
     *
     * @param mixed $where
     * @param bool $includeImages with images
     * @return array|Property[]
     */
    public function findAll($where = null, $includeImages = false){
        $this->getImagesByProperty();
        $model = $this->getModel('Property/Property');
        $result = $model->listQuery($where);
        if ($includeImages) {
            $images = $this->getImagesByProperty();
            foreach ($result as $property) {
                if (isset($images[$property->getId()])) {
                    $property->images = $images[$property->getId()];
                }
            }
        }
        return $result;
    }

    /**
     * Return a set of all Rental Properties that we can iterate over. Single entries of the
     * array are \Property\Entity\Property
     *
     * @return array|Property[]
     */
    public function getRentalProperties(){
        return $this->findAll(array('status_id' => 1));
    }
    
    public function getImagesByProperty($id = false) {
        $images = array();
        $where = $id ? array('property_id = ?' => $id): $id;
        $data = $this->_select('properties_images', null, $where);
        if (is_array($data)) {
            $hydrator = new ObjectProperty();
            foreach ($data as $record) {
                $images[$record['property_id']][] = $hydrator->hydrate($record, new Image());
            }
            $images = $id && isset($images[$id]) ? $images[$id] : $images;
        }
        return $images;
    }

    /**
    * Return an array of specifed property.
    *
    * @param  array $data array of objects (collection)
    * @param  string $property property of objects to be extracted
    * @return array
    */
    public function extract($data, $property){
        return $this->extractCollection($data, $property);
    }



    /**
     * Save a Property and return it. If it is an existing Property it
     * is updated, if it's a new Property it is created.
     *
     * @param  Property $entity
     * @return Property
     */
    public function save(Property $entity){
        $hydrator = new PropertyHydrator();
        $data = $hydrator->extract($entity);

        $this->startTransaction();

        if($entity->getId()){
            $this->_update('properties', $data, array('id = ?' => $entity->getId()));
        }
        else {
            $this->isInsert = true;
            $id = $this->_insert('properties', $data);
            $entity->id = $id;
        }

        /*$images = $this->updateFiles($entity->getImages());
        $entity->setImages($images);*/

        /* property_images
        foreach($images as $i){
            if(!$i->getProperty_id())
                $i->setProperty_id($entity->getId());
        } $this->saveCollection($images, 'properties_images', $do);
        */

        // info
        $this->saveInfo($entity);

        // rentalListing
        $this->saveRentalListing($entity);

        // saleListing
        //$this->saveSaleListing($entity);

        // extras
        $this->saveExtras($entity);

        $this->commitTransaction();

        return $entity;
    }

    /**
     * Delete a given Property and return true if the deletion has been
     * successful or false if not.
     *
     * @param  Property $entity
     * @return bool
     */
    public function delete(Property $entity){
        return $this->_delete('properties', array('id = ?' => $entity->getId()));
    }

    /*private function saveCollection(array $collection, $table, $do){
        $current = $new_ids = $old_ids = array();
        $remove = $do == 'update' ? TRUE : FALSE;

        foreach($collection as $i){
            if($remove){
                foreach($collection as $n)
                    if($n->getRemove()) $old_ids[] = $n->getId();
                $remove = FALSE;
            }

            $data = $this->hydrator->extract($i); 
            unset($data['id']); unset($data['remove']);

            if($i->getId() || $old_ids){
                if(!$i->getId()) $i->setId(array_shift($old_ids));
                $this->_update($table, $data, array('id = ?' => $entity->getId()));
            }else {
                $this->_insert($table, $data);
            }
        }
        
        if($old_ids){
            $this->_delete($table, new In('id', $old_ids));
        } return;
    }*/

    protected function saveExtras(Property $entity) {
        $old = array_diff($entity->getExtraIds(), $entity->getExtraIds(true));
        $new = array_diff($entity->getExtraIds(true), $entity->getExtraIds());
        if ($old || $new) {
            foreach ($new as $id) {
                if ($whereId = array_shift($old)) {
                    $this->_update('property_extras', array('extra_id' => $id),
                        array('property_id = ? AND extra_id = ?' => array($entity->getId(), $whereId)));
                }
                else {
                    $this->_insert('property_extras', array(
                        'property_id' => $entity->getId(),
                        'extra_id' => $id));
                }
            }
            if ($old) {
                $this->_delete('property_extras', array(
                    'property_id = ?' => $entity->getId(), new In('extra_id', $old)));
            }
        }
    }

    protected function saveInfo(Property $entity){
        if (!$entity->getInfo()) {
            $entity->setInfo(new Info());
        }
        $data = $this->hydrator->extract($entity->getInfo());
        if (!empty(array_filter($data))) {
            if ($this->isInsert) {
                $data['property_id'] = $entity->getId();
                $this->_insert('properties_info', $data);
            }
            else {
                $this->_update('properties_info', $data, array('property_id = ?' => $entity->getId()));
            }
        }
        return $entity;
    }

    protected function saveRentalListing(Property $entity){
        if (!$entity->getRentalListing()) {
            $entity->setRentalListing(new RentalListing());
        }
        $data = $this->hydrator->extract($entity->getRentalListing());
        if (!empty(array_filter($data))) {
            if ($this->isInsert) {
                $data['property_id'] = $entity->getId();
                $this->_insert('rental_listings', $data);
            }
            else {
                $this->_update('rental_listings', $data, array('property_id = ?' => $entity->getId()));
            }
        }
        return $entity;
    }

    private function setThumbnail($path){
        try{
            $imagine = new Imagine();
            $img_name = substr($path, strrpos($path, '/')+1);
            $thumb = substr($path, 0, strrpos($path, '/')).'/thumbs/'.$img_name;
            $imagine->open($path)
                ->thumbnail(new Box(160, 120))
                ->save($thumb);    
        }catch(\Exception $e){
            die('Property Mapper: setThumbnail(): Problem creation thumb for: '.$img_name);
        } return true;
    }

    private function updateFiles(array $images){
        $remove = array();
        foreach($images as $k => $i){
            $file = $i->getFile();

            if($file && $i->getRemove()){
                unlink($_SERVER['DOCUMENT_ROOT'].$i->dir.$file);
                if(!$i->getId()) $remove[] = $k;
            } elseif(strpos($file, 'temp') !== false){
                $old = $_SERVER['DOCUMENT_ROOT'].$i->dir.$file;
                $new = str_replace('temp', $_SERVER['DOCUMENT_ROOT'].$i->dir.'property', $file);
                if(rename($old, $new)){
                    $images[$k]->setFile(substr($new, strrpos($new, '/')+1));
                    $this->setThumbnail($new);
                }   
            }  
        } 

        foreach($remove as $k)
            unset($images[$k]);

        return $images;
    }

    public function getExtraOptions() {
        $model = $this->getModel('Property/Extra');
        $extras = $model->listQuery();
        $options = array(
            'extra' => array(),
            'extraType' => array());
        foreach ($extras as $extra) {
            $options['extra'][$extra->getId()] = $extra->getName();
            $options['extraType'][$extra->getTypeId()] = $extra->getTypeName();
        }
        return $options;
    }

    public function extractCollection($data, $property){
        $return = array();
        if(is_array($data)){
            foreach($data as $obj){
                if(is_object($obj))
                    $return[] = $obj->$property;
            }
        } return $return;
    }
}