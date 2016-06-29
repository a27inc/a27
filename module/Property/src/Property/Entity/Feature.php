<?php namespace Property\Entity;

use Application\Entity\EntityAbstract;

class Feature extends EntityAbstract{
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
    public $feature;

    /**
     * @var int
     */
    public $remove;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Feature
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
     * @return Feature
     */
    public function setPropertyId($int){
        $this->propertyId = (int) $int;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeature(){
        return $this->feature;
    }

    /**
     * @param string $feature
     * @return Feature
     */
    public function setFeature($feature){
        $this->feature = (string) $feature;
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
     * @return Feature
     */
    public function setRemove($int){
        $this->remove = (int) $int;
        return $this;
    }   
}