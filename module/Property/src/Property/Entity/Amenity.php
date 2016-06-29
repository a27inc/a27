<?php namespace Property\Entity;

use Application\Entity\EntityAbstract;

class Amenity extends EntityAbstract{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $propertyId;

    /**
     * @var string
     */
    public $amenity;

    /**
     * @var int
     */
    public $int;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Amenity
     */
    public function setId($int){
        $this->id = (int) $int;
        return $this;
    }

    /**
     * @return int
     */
    public function getPropertyId(){
        return $this->propertyId;
    }

    /**
     * @param int $int
     * @return Amenity
     */
    public function setPropertyId($int){
        $this->propertyId = (int) $int;
        return $this;
    }

    /**
     * @return string
     */
    public function getAmenity(){
        return $this->amenity;
    }

    /**
     * @param string $str
     * @return Amenity
     */
    public function setAmenity($str){
        $this->amenity = (string) $str;
        return $this;
    }

    /**
     * @return int
     */
    public function getRemove(){
        return $this->remove;
    }

    /**
     * @param int $int
     * @return Amenity
     */
    public function setRemove($int){
        $this->remove = (int) $int;
        return $this;
    }   
}