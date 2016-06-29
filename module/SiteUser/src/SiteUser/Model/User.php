<?php namespace SiteUser\Model;

use Application\Model\ModelAbstract;

class User extends ModelAbstract{
	public $id;
	public $username;
	public $displayName;
	public $email;

	const USER_STATE_ACTIVE     = 1;
	const USER_STATE_APPROVED   = 2;

	protected function _init(){
		$this->tableName('user')
			->number('id')->primaryKey()
			->string('username')
			->string('email')
			->string('displayName')
			->number('state');

		$this->join('user_role')
			->on('id', 'user_id');

		$this->join('roles')
			->on('user_role', 'role_id', 'id')
			->prefix()
			->number('id')
			->string('role_name', 'name');
	}

	public function exchangeArray($data){
        $this->id     		= (!empty($data['id'])) ? $data['id'] : null;
		$this->username 	= (!empty($data['username'])) ? $data['username'] : null;
		$this->displayName	= (!empty($data['displayName'])) ? $data['displayName'] : null;
		$this->email        = (!empty($data['email'])) ? $data['email'] : null;
	}

    public function getArrayCopy(){
        return get_object_vars($this);
    }
	
	public static function getStateOptions() {
		return array(
			static::USER_STATE_ACTIVE => 'Active - Not Approved',
			static::USER_STATE_APPROVED => 'Active - Approved'
		);
	}
}