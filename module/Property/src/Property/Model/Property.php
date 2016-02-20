<?php namespace Property\Model;

class Property{
    public $id;
	public $zpid;
    public $status;
    public $name;
	public $street;
	public $unit;
	public $city;
	public $state;
	public $zip;

	public function exchangeArray($data){
        $this->id           = (!empty($data['id'])) ? $data['id'] : null;
        $this->zpid         = (!empty($data['zpid'])) ? $data['zpid'] : null;
        $this->status       = (!empty($data['status_id'])) ? $data['status_id'] : null;
        $this->name         = (!empty($data['name'])) ? $data['name'] : null;
        $this->street       = (!empty($data['street_address'])) ? $data['street_address'] : null;
        $this->unit         = (!empty($data['unit'])) ? $data['unit'] : null;
        $this->city         = (!empty($data['city'])) ? $data['city'] : null;
        $this->state        = (!empty($data['state'])) ? $data['state'] : null;
        $this->zip          = (!empty($data['zip'])) ? $data['zip'] : null;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }
}