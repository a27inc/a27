<?php namespace Investor\Model;

class Category{
	public $id;
	public $name;
	public $display_name;
    public $symbol;
	public $description;
	public $note;

	public function exchangeArray($data){
        $this->id     		= (!empty($data['id'])) ? $data['id'] : null;
		$this->name 		= (!empty($data['name'])) ? $data['name'] : null;
		$this->display_name	= (!empty($data['display_name'])) ? $data['display_name'] : null;
		$this->symbol       = (!empty($data['symbol'])) ? $data['symbol'] : null;
        $this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->note  		= (!empty($data['note'])) ? $data['note'] : null;
	}

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}