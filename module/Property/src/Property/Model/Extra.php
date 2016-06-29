<?php namespace Property\Model;

use Application\Model\ModelAbstract;

class Extra extends ModelAbstract{
    public $id;
	public $typeId;
    public $name;

    protected function _init(){
        $this->tableName('extra')
            ->number('id')->primaryKey()
            ->number('type_id')
            ->string('name');

        $this->join('extra_type')
            ->on('type_id', 'id')
            ->string('name', 'typeName');
    }

	public function exchangeArray($data){
        $this->id       = (!empty($data['id'])) ? $data['id'] : null;
        $this->typeId   = (!empty($data['type_id'])) ? $data['type_id'] : null;
        $this->name     = (!empty($data['name'])) ? $data['name'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}