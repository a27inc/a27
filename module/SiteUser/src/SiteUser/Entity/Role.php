<?php namespace SiteUser\Entity;

use Application\Entity\EntityAbstract;

class Role extends EntityAbstract{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $childId;

    /**
     * @var int
     */
    public $parentId;

    /**
     * @var array
     */
    public $permissionIds = array();

    /**
     * @var array Permission
     */
    public $permissionsByName = array();

    /**
     * @var array Permission
     */
    public $permissionsById = array();

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $int
     * @return Role
     */
    public function setId($int) {
        $this->id = (int) $int;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $str
     * @return Role
     */
    public function setName($str) {
        $this->name = $str;
        return $this;
    }

    /**
     * @return int
     */
    public function getChildId() {
        return $this->childId;
    }

    /**
     * @param int $int
     * @return Role
     */
    public function setChildId($int) {
        $this->childId = $int;
        return $this;
    }

    /**
     * @return int
     */
    public function getParentId() {
        return $this->parentId;
    }

    /**
     * @param int $int
     * @return Role
     */
    public function setParentId($int) {
        $this->parentId = $int;
        return $this;
    }

    /**
     * @param Permission $obj
     * @return Role
     */
    public function addPermission(Permission $obj) {
        $this->permissionIds[] = $obj->getId();
        $this->permissionsById[$obj->getId()] = $obj;
        $this->permissionsByName[$obj->getName()] = $obj;
        return $this;
    }

    /**
     * @param mixed $permission id or name
     * @return bool
     */
    public function hasPermission($permission) {
        return isset($this->permissionsByName[$permission]) || isset($this->permissionsById[$permission]);
    }

    /**
     * Returns the current role permissions in the database
     * 
     * @param bool $byName return by name, defaults to returning by id
     * @return array
     */
    public function getPermissions($byName = false) {
        return $byName ? $this->permissionsByName : $this->permissionsById;
    }

    /**
     * Returns role permissions after a form submit to be saved
     * 
     * @return array
     */
    public function getPermissionIds() {
        return $this->permissionIds;
    }

    /**
     * @param array $arr
     * @return Role
     */
    public function setPermissionIds($arr) {
        $this->permissionIds = $arr;
        return $this;
    }

    /**
     * @return array
     */
    public function getPermissionNames() {
        return array_keys($this->permissionsByName);
    }

    /**
     * @return string
     */
    public function __toString(){
        return $this->getName() ?: '';
    }
}