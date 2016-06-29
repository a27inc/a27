<?php namespace SiteUser\Entity;

use Application\Entity\EntityAbstract;

class User extends EntityAbstract{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $email;

    /**
     * @var int
     */
    public $displayName;

    /**
     * @var int
     */
    public $state;

    /**
     * @var array
     */
    public $roleIds = array();

    /**
     * @var array
     */
    protected $rolesById = array();

    /**
     * @var array
     */
    protected $rolesByName = array();

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @return string
     */
    public function getDisplayName(){
        return $this->displayName;
    }

    /**
     * @return int
     */
    public function getState(){
        return $this->state;
    }

    /**
     * @param Role $obj
     * @return User
     */
    public function addRole(Role $obj){
        $this->roleIds[] = $obj->getId();
        $this->rolesById[$obj->getId()] = $obj;
        $this->rolesByName[$obj->getName()] = $obj;
        return $this;
    }

    /**
     * @param mixed $role
     * @return bool
     */
    public function hasRole($role) {
        return isset($this->rolesByName[$role]) || isset($this->rolesById[$role]);
    }

    /**
     * Returns the current user roles in the database
     *
     * @param bool $byName return by name, defaults to returning by id
     * @return  array
     */
    public function getRoles($byName = false){
        return $byName ? $this->rolesByName : $this->rolesById;
    }

    /**
     * @return array
     */
    public function getRoleIds() {
        return $this->roleIds;
    }

    /**
     * @return  array
     */
    public function getRoleNames(){
        return array_keys($this->rolesByName);
    }

    /**
     * @return string
     */
    public function __toString(){
        if ($this->displayName) {
            return $this->displayName;
        }
        else if ($this->email) {
            return $this->email;
        }
        return '';
    }
}