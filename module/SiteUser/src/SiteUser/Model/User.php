<?php namespace SiteUser\Model;

class User{
	public $id;
	public $username;
	public $displayName;
	public $email;

	public function exchangeArray($data){
        $this->id     		= (!empty($data['id'])) ? $data['id'] : null;
		$this->username 	= (!empty($data['username'])) ? $data['username'] : null;
		$this->displayName	= (!empty($data['displayName'])) ? $data['displayName'] : null;
		$this->email        = (!empty($data['email'])) ? $data['email'] : null;
	}

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}