<?php namespace Property\Entity;

use Application\Entity\EntityAbstract;

class Extra extends EntityAbstract{
    const TYPE_AMENITY = 1;
    const TYPE_INCLUDE = 2;
    const TYPE_FEATURE = 3;
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $typeId;

    /**
     * @var string
     */
    public $typeName;

    /**
     * @var string
     */
    public $name;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Extra
     */
    public function setId($int){
        $this->id = (int) $int;
        return $this;
    }

    /**
     * @return int
     */
    public function getTypeId(){
        return $this->typeId;
    }

    /**
     * @return string
     */
    public function getTypeName(){
        return $this->typeName;
    }

    /**
     * @param int $int
     * @return Extra
     */
    public function setTypeId($int){
        $this->typeId = (int) $int;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $str
     * @return Extra
     */
    public function setName($str){
        $this->name = (string) $str;
        return $this;
    }
}