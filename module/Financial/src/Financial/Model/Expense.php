<?php namespace Financial\Model;

use Application\Model\ModelAbstract;

class Expense extends ModelAbstract{
	
	public $id;
	public $property_id;
    public $category_id;
	public $rate_id;
	public $amount;
    public $date_filed;
    public $date_from;
    public $date_to;
	public $description;
	public $note;
	
	protected $inputFilter;

	protected function _init() {
		$this->tableName('expenses')
			->number('id')->primaryKey()
            ->number('author_id')
			->string('amount')
			->string('date_filed')
			->string('date_from')
			->string('date_to')
			->string('description')
			->string('note');

		$this->join('properties')
			->on('property_id')
			->prefix()
			->number('id')
			->number('zpid')
			->number('status_id')
			->string('name')
			->string('street_address')
			->string('unit')
			->string('city')
			->string('state')
			->number('zip');

		$this->join('financial_categories')
			->on('category_id')
			->prefix()
			->number('id')
			->string('name')
			->string('display_name')
			->string('description')
			->string('note')
			->boolean('excl_cash_flow')
			->boolean('excl_all');

		$this->join('rates')
			->on('rate_id')
			->prefix()
			->number('id')
			->string('name')
			->number('monthly')
			->number('quarterly')
			->number('semi_annual')
			->number('annual');
	}

	public function exchangeArray($data){
		$this->id   		= (!empty($data['id'])) ? $data['id'] : null;
		$this->property_id 	= (!empty($data['property_id'])) ? $data['property_id'] : null;
        $this->category_id  = (!empty($data['category_id'])) ? $data['category_id'] : null;
		$this->rate_id  	= (!empty($data['rate_id'])) ? $data['rate_id'] : null;
		$this->amount  		= (!empty($data['amount'])) ? $data['amount'] : null;
        $this->date_filed   = (!empty($data['date_filed'])) ? $data['date_filed'] : null;
        $this->date_from    = (!empty($data['date_from'])) ? $data['date_from'] : null;
        $this->date_to      = (!empty($data['date_to'])) ? $data['date_to'] : null;
		$this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->note  		= (!empty($data['note'])) ? $data['note'] : null;
	}

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}