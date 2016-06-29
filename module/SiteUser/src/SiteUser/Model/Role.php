<?php namespace SiteUser\Model;

use Application\Model\ModelAbstract;

class Role extends ModelAbstract{
    public $id;
    public $name;

    protected function _init(){
        $this->tableName('roles')
            ->number('id')->primaryKey()
            ->string('role_name', 'name');

        $this->join('role_role')
            ->on('id', 'parent_id')
            ->number('parent_id')
            ->number('child_id');

        $this->join('role_permission')
            ->on('id', 'role_id');

        $this->join('permissions')
            ->on('role_permission', 'permission_id', 'id')
            ->prefix()
            ->number('id')
            ->string('permission_name', 'name');
    }

    public function exchangeArray($data){
        $this->id   = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['role_name'])) ? $data['role_name'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}