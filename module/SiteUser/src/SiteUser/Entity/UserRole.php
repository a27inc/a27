<?php namespace SiteUser\Entity;

use SiteUser\Entity\Role;

class UserRole{
    /**
     * @var int
     */
    public $user_id;

    /**
     * @var Role[]
     */
    public $roles;

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
    public function __construct($user_id = NULL){
        if($user_id)
            $this->user_id  = (int) $user_id;
    }

    /**
     * @return int
     */
    public function getUser_id(){
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUser_id($id){
        $this->user_id = (int) $id;
        return $this;
    }

    /**
     * @return array Role[]
     */
    public function getRoles(){
        return $this->roles ? $this->roles : array();
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
     * @param Role $role
     */
    public function addRole(Role $role){
        $this->roles[] = $role;
        
        if(empty($this->ids))
            $this->ids = array();
        $this->ids[] = $role->getId();

        if(empty($this->names))
            $this->names = array();
        $this->names[] = $role->getName();
        return $this;
    }
}