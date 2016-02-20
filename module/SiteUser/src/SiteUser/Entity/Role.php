<?php namespace SiteUser\Entity;

class Role{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var RoleChild
     */
    public $child;

    /**
     * @var RolePermission
     */
    public $permission;

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
    public function setRole_id($id){
        $this->hydrator_flag['id'] = true;
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string
     */
    public function getRole_name(){
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setRole_name($name){
        $this->name = $name;
    }

    /**
     * @param RolePermission
     */
    public function getPermission(){
        return $this->permission;
    }

    /**
     * @return RolePermission $permission
     */
    public function setPermission(RolePermission $permission){
        $this->permission = $permission;
    }

    /**
     * @param RoleChild
     */
    public function getChild(){
        return $this->child;
    }

    /**
     * @return RolePermission $permission
     */
    public function setChild(RoleChild $child){
        $this->child = $child;
    }
}