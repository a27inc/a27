<?php namespace SiteUser\Entity;

class RoleChild{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $parent_id;

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
     * @return int
     */
    public function getChild_id(){
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setChild_id($id){
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getParent_id(){
        return $this->parent_id;
    }

    /**
     * @param int $id
     */
    public function setParent_id($id){
        $this->parent_id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setChild_name($name){
        $this->name = $name;
        return $this;
    }
}