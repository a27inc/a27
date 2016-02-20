<?php namespace SiteUser\Entity;

use SiteUser\Entity\Permission;

class RolePermission{
    /**
     * @var int
     */
    public $role_id;

    /**
     * @var Permission[]
     */
    public $permissions;

    /**
     * @var array
     */
    public $names;

    /**
     * @var array
     */
    public $ids;

    /**
     * Constructor
     */
    public function __construct($role_id = NULL){
        if($role_id)
            $this->role_id  = (int) $role_id;
    }

    /**
     * @return int
     */
    public function getRole_id(){
        return $this->role_id;
    }

    /**
     * @param int $role_id
     */
    public function setRole_id($id){
        $this->role_id = (int) $id;
        return $this;
    }

    /**
     * @return array Permission[]
     */
    public function getPermissions(){
        return $this->permissions ? $this->permissions : array();
    }

    /**
     * @return string
     */
    public function getNames(){
        return $this->names ? $this->names : array();
    }

    /**
     * @return array
     */
    public function getIds(){
        return $this->ids ? $this->ids : array();
    }

    /**
     * @param array
     */
    public function setIds($ids){
        $this->ids = $ids;
        return $this;
    }

    /**
     * @param Permission $permission
     */
    public function addPermission(Permission $permission){
        $this->permissions[] = $permission;
        
        if(empty($this->ids))
            $this->ids = array();
        $this->ids[] = $permission->getId();

        if(empty($this->names))
            $this->names = array();
        $this->names[] = $permission->getName();
        return $this;
    }
}