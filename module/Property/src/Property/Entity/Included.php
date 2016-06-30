<?php namespace Property\Entity;

use Application\Entity\EntityAbstract;

class Included extends EntityAbstract{
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
    public $include;

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
     * @return Included
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
     * @return Included
     */
    public function setPropertyId($int){
        $this->propertyId = (int) $int;
        return $this;
    }

    /**
     * @return string
     */
    public function getInclude(){
        return $this->include;
    }

    /**
     * @param string $str
     * @return Included
     */
    public function setInclude($str){
        $this->include = (string) $str;
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
     * @return Included
     */
    public function setRemove($int){
        $this->remove = (int) $int;
        return $this;
    }   
}