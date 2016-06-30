<?php namespace SiteUser\Entity;

use Application\Entity\EntityAbstract;

class Permission extends EntityAbstract{
    /**
     * @var int
     */
    public $id;

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
     * @return Permission
     */
    public function setId($int){
        $this->id = (int) $int;
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
     * @return Permission
     */
    public function setName($str){
        $this->name = $str;
        return $this;
    }
}