<?php namespace SiteUser\Model;

use Application\Model\ModelAbstract;

class Permission extends ModelAbstract{
    public $id;
    public $name;

    protected function _init(){
        $this->tableName('permissions')
            ->number('id')->primaryKey()
            ->string('permission_name', 'name');
    }

    public function exchangeArray($data){
        $this->id   = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['permission_name'])) ? $data['permission_name'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}