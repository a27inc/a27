<?php namespace Financial\Model;

class Income{
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

	public function exchangeArray($data){
		$this->id    = (!empty($data['id'])) ? $data['id'] : null;
		$this->property_id 	= (!empty($data['property_id'])) ? $data['property_id'] : null;
        $this->category_id  = (!empty($data['category_id'])) ? $data['category_id'] : null;
		$this->rate_id  	= (!empty($data['rate_id'])) ? $data['rate_id'] : null;
		$this->amount  		= (!empty($data['amount'])) ? $data['amount'] : null;
        $this->date_filed   = (!empty($data['date_filed'])) ? $data['date_filed'] : null;
        $this->date_from    = (!empty($data['date_from'])) ? $data['date_from'] : null;
        $this->date_to      = (!empty($data['date_to'])) ? $data['date_to'] : null;
        $this->description  = (!empty($data['description'])) ? $data['description'] : null;
        $this->note         = (!empty($data['note'])) ? $data['note'] : null;
	}

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}