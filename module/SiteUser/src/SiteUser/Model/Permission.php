<?php namespace SiteUser\Model;

class Permission{
    public $id;
    public $name;

    public function exchangeArray($data){
        $this->id   = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['permission_name'])) ? $data['permission_name'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}