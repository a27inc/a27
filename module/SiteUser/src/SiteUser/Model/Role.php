<?php namespace SiteUser\Model;

class Role{
    public $id;
    public $name;

    public function exchangeArray($data){
        $this->id   = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['role_name'])) ? $data['role_name'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}