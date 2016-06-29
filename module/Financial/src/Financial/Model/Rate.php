<?php namespace Financial\Model;

class Rate{
	public $id;
	public $name;
	public $monthly;
	public $quarterly;
	public $semi_annual;
	public $annual;

	public function exchangeArray($data){
		$this->id     	= (!empty($data['id'])) ? $data['id'] : null;
		$this->name  	= (!empty($data['name'])) ? $data['name'] : null;
		$this->monthly 		= (!empty($data['monthly'])) ? $data['monthly'] : null;
		$this->quarterly  	= (!empty($data['quarterly'])) ? $data['quarterly'] : null;
		$this->semi_annual  	= (!empty($data['semi_annual'])) ? $data['semi_annual'] : null;
		$this->annual  		= (!empty($data['annual'])) ? $data['annual'] : null;
	}

	public function getArrayCopy(){
        return get_object_vars($this);
    }
}