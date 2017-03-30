<?php namespace Property\Model;

use Application\Model\ModelAbstract;

class Property extends ModelAbstract{
    public $id;
	public $zpid;
    public $status;
    public $name;
	public $street;
	public $unit;
	public $city;
	public $state;
	public $zip;

	const STATUS_FOR_RENT = 1;
	const STATUS_FOR_SALE = 2;
	const STATUS_DISABLED = 3;

    protected function _init(){
        $this->tableName('properties')
            ->number('id')->primaryKey()
            ->number('zpid')
            ->number('status_id')
            ->string('name')
            ->string('street_address')
            ->string('unit')
            ->string('city')
            ->string('state')
            ->number('zip');

        $this->join('properties_info')
            ->on('id', 'property_id')
            ->prefix()
            ->number('sqft')
            ->number('bedrooms')
            ->number('bathrooms')
            ->setVisibility(static::MODE_ITEM)
                ->number('property_taxes')
                ->number('hoa_fees')
                ->number('year_built');

        $this->join('properties_description')
            ->on('id', 'property_id')
            ->prefix()
            ->visibility(static::MODE_ITEM)
            ->string('summary')
            ->string('notes');
            

        $this->join('rental_listings')
            ->on('id', 'property_id')
            ->prefix()
            ->number('rent')
            ->number('deposit')
            ->string('available')
            ->setVisibility(static::MODE_ITEM)
                ->string('contact_name')
                ->string('contact_number')
                ->string('summary')
                ->string('notes')
                ->string('cta_button')
                ->string('cta_title')
                ->string('cta_message')
                ->string('cta_footer');

        $this->join('property_extras')
            ->on('id', 'property_id')
            ->visibility(static::MODE_ITEM);

        $this->join('extra')
            ->on('property_extras', 'extra_id', 'id')
            ->prefix()
            ->visibility(static::MODE_ITEM)
            ->number('id')
            ->number('type_id')
            ->string('name');
    }

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