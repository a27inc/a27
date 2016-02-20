<?php namespace SiteUser\Entity;

class Permission{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    // prevent hydrating with similar fields from other tables
    private $hydrator_flag = array(
        'id' => false);

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id){
        if(!$this->hydrator_flag['id'])
            $this->id = (int) $id;
        return $this;
    }

    /**
     * @param int $id
     */
    public function setPermission_id($id){
        $this->hydrator_flag['id'] = true;
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPermission_id(){
        return $this->id;
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
    public function setName($name){
        if(!$this->hydrator_flag['name'])
            $this->name = $name;
        return $this;
    }

    /**
     * @param string $name
     */
    public function setPermission_name($name){
        $this->hydrator_flag['name'] = true;
        $this->name = $name;
        return $this;
    }

    /**
     * @return string $name
     */
    public function getPermission_name(){
        return $this->name;
    }
}