<?php namespace Investor\Entity;

use SiteUser\Entity\User;
use Property\Entity\Property;
use Application\Entity\EntityAbstract;

class Allocation extends EntityAbstract{
    /**
     * @var int
     */
    public $id; 

    /**
     * @var User
     */
    public $user;

    /**
     * @var Category
     */
    public $category;

    /**
     * @var Property
     */
    public $property;

    /**
     * @var float
     */
    public $allocation;

    /**
     * @var string
     */
    public $note;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Allocation
     */
    public function setId($int){
        $this->id = (int) $int;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @param User $obj
     * @return Allocation
     */
    public function setUser(User $obj){
        $this->user = $obj;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     * @param Category $obj
     * @return Allocation
     */
    public function setCategory(Category $obj){
        $this->category = $obj;
        return $this;
    }

    /**
     * @return Property
     */
    public function getProperty(){
        return $this->property;
    }

    /**
     * @param Property $obj
     * @return Allocation
     */
    public function setProperty(Property $obj){
        $this->property = $obj;
        return $this;
    }

    /**
     * @return string
     */
    public function getAllocation(){
        return $this->allocation;
    }

    /**
     * @param string $str
     * @return Allocation
     */
    public function setAllocation($str){
        $this->allocation = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $str
     * @return Allocation
     */
    public function setNote($str){
        $this->note = $str;
        return $this;
    }
}