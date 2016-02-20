<?php namespace Property\Service;

use Property\Entity\Property;
use Property\Entity\PropertyInfo;
use Property\Entity\PropertyImage;
use Property\Entity\PropertyFeature;
use Property\Entity\PropertyAmenity;
use Property\Entity\PropertyInclude;
use Property\Entity\RentalListing;
use Property\Entity\SaleListing;

use \Imagine\Gd\Imagine;
use \Imagine\Image\Box;
use \Imagine\Image\Point;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Stdlib\Hydrator\ClassMethods;

class PropertyService{
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    /**
     * @param AdapterInterface  $dbAdapter
     * @param HydratorInterface $hydrator
     */
    public function __construct(AdapterInterface $dbAdapter){
        $this->dbAdapter = $dbAdapter;
        $this->hydrator  = new ClassMethods(FALSE);
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
    * Return a set of all Properties that we can iterate over. Single entries of the 
    * array are \Property\Entity\Property
    *
    * @return array|Property[]
    */
    public function findAllProperties($where = NULL){
        return $this->findAll($where);    
    }

    /**
    * Return a single Property
    *
    * @param  int $id Identifier of the Property to be returned
    * @return Property
    */
    public function findProperty($id){
        $property = $this->find($id);
        return $property;    
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

    /**
    * Returns an array of images by property id
    *
    * @param  int $id Identifier of the Property to be returned
    * @return Property
    */
    public function getImagesByProperty(){
        return $this->getCollection('properties_images');
    }

    /**
    * Return meta description for property detail page 
    *
    * @return array|Property[]
    */
    public function getMetaDescription($property, $amenities, $features, $includes){
        $meta_desc = $property->info->bedrooms.' bed '.
            $property->info->bathrooms.' bath';
        
        switch($property->status_id){
            case 1: $meta_desc .= ' condo for rent'; break;
            case 2: $meta_desc .= ' home for sale'; break;
        }

        $meta_desc .= ' in '.$property->city.', '.$property->state.'.';

        $meta_amenities = $amenities 
            ? ' Amenities: ' . implode(', ', $amenities) : '';
        if((strlen($meta_desc) + strlen($meta_amenities)) <= 160)
            $meta_desc .= $meta_amenities;

        $meta_features = $features 
            ? ' Features: ' . implode(', ', $features) : '';
        if((strlen($meta_desc) + strlen($meta_features)) <= 160)
            $meta_desc .= $meta_features;

        $meta_includes = $includes 
            ? ' Included: ' . implode(', ', $includes) : '';
        if((strlen($meta_desc) + strlen($meta_includes)) <= 160)
            $meta_desc .= $meta_includes;

        return $meta_desc;        
    }

    /**
    * Return Property address
    *
    * @return string
    */
    public function getAddress($property){
        $address = $property->street_address;
        /*if($property->unit) 
            $address .= ' #'.$property->unit;*/
        $address .= ', '.$property->city;
        $address .= ', '.$property->state;
        $address .= ' '.$property->zip;
        return $address;        
    }

    /**
     * Save a Property and return it. If it is an existing Property it
     * is updated, if it's a new Property it is created.
     *
     * @param  Property $property
     * @return Property
     */
    public function saveProperty(Property $property){
        return $this->save($property);    
    }

    /**
     * Delete a given Property and return true if the deletion has been
     * successful or false if not.
     *
     * @param  Property $property
     * @return bool
     */
    public function deleteProperty(Property $property){
        return $this->delete($property);    
    }

    public function delete(Property $propertyObject){
        $action = new Delete('properties');
        $action->where(array('id = ?' => $propertyObject->getId()));

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
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

    public function find($id){
        $property = $this->findAll('p.id = '.$id);
        return array_shift($property);
    }

    public function findAll($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('p' => 'properties'))
            //->columns(array('pid' => 'id', '*'))
            ->join(array('pi' => 'properties_info'), 'p.id = pi.property_id', '*', 'left')
            ->join(array('rl' => 'rental_listings'), 'p.id = rl.property_id', '*', 'left');

        if($where) $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            $properties = array();
            while($data = $result->current()){
                $property = new Property();
                if(empty($data['property_id'])) 
                    $data['property_id'] = $data['id'];

                $property->setInfo(
                    $this->hydrator->hydrate($data, new PropertyInfo()));

                $property->setRental_listing(
                    $this->hydrator->hydrate($data, new RentalListing()));
                
                $property->setImages(
                    $this->getCollection('properties_images', $data['property_id']));

                $property->setFeatures(
                    $this->getCollection('properties_features', $data['property_id']));

                $property->setAmenities(
                    $this->getCollection('properties_amenities', $data['property_id']));

                $property->setIncludes(
                    $this->getCollection('properties_includes', $data['property_id']));    

                $properties[$data['property_id']] = $this->hydrator->hydrate($data, $property);
                $result->next();
            } return $properties;
        } return array();
    }

    public function getCollection($table, $property_id = NULL){
        switch($table){
            case 'properties_images': 
                $entity = new PropertyImage(); break;
            case 'properties_features': 
                $entity = new PropertyFeature(); break;
            case 'properties_amenities': 
                $entity = new PropertyAmenity(); break;
            case 'properties_includes': 
                $entity = new PropertyInclude(); break;
            default: die('Property Mapper: Collection for table '.$table.' not recognized!');
        }
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select($table);

        if($property_id) $select->where(array('property_id' => $property_id));

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $entity->setProperty_id($property_id);

        if($result instanceof ResultInterface && $result->isQueryResult()){  
            $resultSet = new HydratingResultSet($this->hydrator, $entity);
            $results = $resultSet->initialize($result);

            $items = array();
            foreach($results as $r){ 
                if(!$property_id) 
                    $items[$r->property_id][] = $r;
                else $items[] = $r;
            } return $items ? $items : array($entity);
        } return array($entity);
    }

    public function save(Property $property){
        $images = $this->updateFiles($property->getImages());
        $property->setImages($images);

        $data = $this->hydrator->extract($property);
        unset($data['id']);

        // Get rental_listing
        $rental_listing = $data['rental_listing'];
        unset($data['rental_listing']);
        //var_dump($rental_listing);

        // Get sale_listing
        $sale_listing = $data['sale_listing'];
        unset($data['sale_listing']);
        //var_dump($sale_listing);

        // Get info
        $info = $data['info'];
        unset($data['info']);
        //var_dump($info);

        // Get images
        $images = $data['images'];
        unset($data['images']);
        //var_dump($images);

        // Get features
        $features = $data['features'];
        unset($data['features']);
        //var_dump($features);

        // Get amenities
        $amenities = $data['amenities'];
        unset($data['amenities']);
        //var_dump($amenities);

        // Get property_includes
        $includes = $data['includes'];
        unset($data['includes']);
        //var_dump($includes); die;

        $do = 'insert';
        if($property->getId()){
            $do = 'update';
            $action = new Update('properties');
            $action->set($data);
            $action->where(array('id = ?' => $property->getId()));
        } else{ // ID NOT present, it's an Insert
            $action = new Insert('properties');
            $action->values($data);
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){
            if($newId = $result->getGeneratedValue())
                $property->setId($newId);
            
            // property_info
            if(!$info->getProperty_id())
                $info->setProperty_id($property->getId());
            $this->saveInfo($info, $do);

            // rental_listing
            if($rental_listing){
                $do_action = $do;
                if(!$rental_listing->getProperty_id()){
                    $rental_listing->setProperty_id($property->getId());
                    $do_action = 'insert';
                } $this->saveRentalListing($rental_listing, $do_action);
            }

            // sale_listing
            if($sale_listing){
                $do_action = $do;
                if(!$sale_listing->getProperty_id()){
                    $sale_listing->setProperty_id($property->getId());
                    $do_action = 'insert';
                } $this->saveSaleListing($sale_listing, $do_action);
            }

            // property_images
            foreach($images as $i){
                if(!$i->getProperty_id())
                    $i->setProperty_id($property->getId());
            } $this->saveCollection($images, 'properties_images', $do);

            // property_features
            if($features){
                foreach($features as $i){
                    if(!$i->getProperty_id())
                        $i->setProperty_id($property->getId());
                } $this->saveCollection($features, 'properties_features', $do);
            }

            // property_amenities
            if($amenities){
                foreach($amenities as $i){
                    if(!$i->getProperty_id())
                        $i->setProperty_id($property->getId());
                } $this->saveCollection($amenities, 'properties_amenities', $do);
            }

            // property_includes
            if($includes){
                foreach($includes as $i){
                    if(!$i->getProperty_id())
                        $i->setProperty_id($property->getId());
                } $this->saveCollection($includes, 'properties_includes', $do);
            }
            return $property;
        } throw new \Exception('Database error: save()');
    }

    private function saveCollection(array $collection, $table, $do){       
        $current = $new_ids = $old_ids = array();
        $remove = $do == 'update' ? TRUE : FALSE;

        foreach($collection as $i){
            if($remove){
                foreach($collection as $n)
                    if($n->getRemove()) $old_ids[] = $n->getId();
                $remove = FALSE;
            }

            $item = $this->hydrator->extract($i); 
            unset($item['id']); unset($item['remove']);

            if($i->getId() || $old_ids){
                if(!$i->getId()) $i->setId(array_shift($old_ids));
                $action = new Update($table);
                $action->set($item);
                $action->where(array('id = ?' => $i->getId()));
            }else {
                $action = new Insert($table);
                $action->values($item);
            }

            $sql    = new Sql($this->dbAdapter);
            $stmt   = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute();
            if(!$result instanceof ResultInterface) 
                throw new \Exception('Database error: '.$table.' insert/update');
        }
        
        if($old_ids){
            $action = new Delete($table);
            $action->where(array('id IN(?)' => implode(',', $old_ids))); 
            $sql    = new Sql($this->dbAdapter);
            $stmt   = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute(); 
            if(!$result instanceof ResultInterface) 
                throw new \Exception('Database error: removing old '.$collection.' ids');  
        } return;
    }

    public function saveInfo(PropertyInfo $info, $do){       
        $data = $this->hydrator->extract($info);
        unset($data['property_id']);

        switch($do){
            case 'insert':
                $action = new Insert('properties_info');
                $action->values($data);
                break;    
            case 'update':
                $action = new Update('properties_info');
                $action->set($data);
                $action->where(array('property_id = ?' => $info->getProperty_id()));
                break;
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){
            return;
        } throw new \Exception('Database error: savePropertyInfo()');
    }

    private function saveRentalListing(RentalListing $listing, $do){       
        $data = $this->hydrator->extract($listing);

        switch($do){
            case 'insert':
                $action = new Insert('rental_listings');
                $action->values($data);
                break;    
            case 'update':
                unset($data['property_id']);
                $action = new Update('rental_listings');
                $action->set($data);
                $action->where(array('property_id = ?' => $listing->getProperty_id()));
                break;
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){
            return;
        } throw new \Exception('Database error: saveRentalListing()');
    }

    private function setThumbnail($path){
        try{
            $imagine = new Imagine();
            $img_name = substr($path, strrpos($path, '/')+1);
            $thumb = substr($path, 0, strrpos($path, '/')).'/thumbs/'.$img_name;
            $imagine->open($path)
                ->thumbnail(new Box(160, 120))
                ->save($thumb);    
        }catch(\Imagine\Exception\Exception $e){
            die('Property Mapper: setThumbnail(): Problem creation thumb for: '.$img_name);
        } return TRUE; 
    }

    private function updateFiles(array $images){
        $remove = array();
        foreach($images as $k => $i){
            $file = $i->getFile();

            if($file && $i->getRemove()){
                unlink($_SERVER['DOCUMENT_ROOT'].$i->dir.$file);
                if(!$i->getId()) $remove[] = $k;
            } elseif(strpos($file, 'temp') !== FALSE){
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
}