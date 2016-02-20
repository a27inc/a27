<?php namespace Financial\Model;

class Category{
	public $id;
	public $name;
	public $display_name;
	public $description;
	public $note;
    public $excl_cash_flow;

	public function exchangeArray($data){
        $this->id     		= (!empty($data['id'])) ? $data['id'] : null;
		$this->name 		= (!empty($data['name'])) ? $data['name'] : null;
		$this->display_name	= (!empty($data['display_name'])) ? $data['display_name'] : null;
		$this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->note  		= (!empty($data['note'])) ? $data['note'] : null;
        $this->excl_cash_flow = (!empty($data['excl_cash_flow'])) ? $data['excl_cash_flow'] : null;
	}

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}