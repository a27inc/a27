<?php namespace Landlord\Model;

use Application\Model\ModelAbstract;

class Tenant extends ModelAbstract{
	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $firstName;

	/**
	 * @var string
	 */
	public $middleInitial;

	/**
	 * @var string
	 */
	public $lastName;

	/**
	 * @var string
	 */
	public $birthDate;

	/**
	 * @var string
	 */
	public $code;

	protected function _init(){
		$this->tableName('tenants')
			->number('id')->primaryKey()
			->string('first_name')
			->string('middle_initial')
			->string('last_name')
			->string('birth_date')
			->string('code');
	}

	public function exchangeArray($data){
        $this->id     			= (!empty($data['id'])) ? $data['id'] : null;
		$this->firstName 		= (!empty($data['first_name'])) ? $data['first_name'] : null;
		$this->middleInitial	= (!empty($data['middle_initial'])) ? $data['middle_initial'] : null;
		$this->lastName 		= (!empty($data['last_name'])) ? $data['last_name'] : null;
		$this->birthDate 		= (!empty($data['birth_date'])) ? $data['birth_date'] : null;
		$this->code        		= (!empty($data['code'])) ? $data['code'] : null;
	}

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}