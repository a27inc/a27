<?php namespace Investor\Model;

use Application\Model\ModelAbstract;

class Category extends ModelAbstract{
	public $id;
	public $name;
	public $displayName;
    public $symbol;
	public $description;
	public $note;

	protected function _init(){
		$this->tableName('allocation_categories')
			->number('id')->primaryKey()
			->string('name')
			->string('display_name')
			->string('symbol')
			->string('description')
			->string('note');
	}

	public function exchangeArray($data){
        $this->id     		= (!empty($data['id'])) ? $data['id'] : null;
		$this->name 		= (!empty($data['name'])) ? $data['name'] : null;
		$this->displayName	= (!empty($data['display_name'])) ? $data['display_name'] : null;
		$this->symbol       = (!empty($data['symbol'])) ? $data['symbol'] : null;
        $this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->note  		= (!empty($data['note'])) ? $data['note'] : null;
	}

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}