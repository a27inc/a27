<?php namespace Financial\Model;

class Rate{
	public $id;
	public $name;
	public $monthly;
	public $quarterly;
	public $semi_anual;
	public $anual;

	public function exchangeArray($data){
		$this->id     	= (!empty($data['id'])) ? $data['id'] : null;
		$this->name  	= (!empty($data['name'])) ? $data['name'] : null;
		$this->monthly 		= (!empty($data['monthly'])) ? $data['monthly'] : null;
		$this->quarterly  	= (!empty($data['quarterly'])) ? $data['quarterly'] : null;
		$this->semi_anual  	= (!empty($data['semi_anual'])) ? $data['semi_anual'] : null;
		$this->anual  		= (!empty($data['anual'])) ? $data['anual'] : null;
	}

	public function getArrayCopy(){
        return get_object_vars($this);
    }
}