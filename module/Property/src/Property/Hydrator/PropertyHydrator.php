<?php namespace Property\Hydrator;

use Property\Entity\Property;
use Property\Entity\PropertyInfo;
use Zend\Stdlib\Hydrator\ClassMethods;

class PropertyHydrator extends ClassMethods{
    protected $_dataMap;

    public function __construct($underscoreSeparatedKeys = FALSE){
        parent::__construct($underscoreSeparatedKeys);

        $this->_dataMap = array(
            'property_info' => new PropertyInfo());
    }

    public function stdHydrate(array $data, $object){
        return parent::hydrate($data, $object);   
    }

    public function hydrate(array $data, $object){       
        return parent::hydrate($data, $object);

        if(!$object instanceof Property){
            return $object;
        }

        foreach($data as $property => $value){
            if(!property_exists($object, $property)){
                if(is_array($value)){
                    var_dump($value);
                } else{
                    foreach($this->_dataMap as $_prop => $_obj){
                        $method = 'set' . ucfirst($property);    
                        if(is_callable(array($_obj, $method)))
                            $this->_dataMap[$_prop]->$method($value);
                    }
                }
            } else{ 
                $method = 'set' . ucfirst($this->hydrateName($property, $data));
                if(is_callable(array($object, $method))){
                    $value = $this->hydrateValue($property, $value, $data);
                    $object->$method($value);
                }
            }
        } 

        foreach($this->_dataMap as $_prop => $_obj){
            $data[$_prop] = $_obj;   
            $method = 'set' . ucfirst($this->hydrateName($_prop, $_obj));    
            if(is_callable(array($object, $method))){
                $value = $this->hydrateValue($_prop, $_obj, $data);
                $object->$method($value);
            }
        } return $object;
    }
}