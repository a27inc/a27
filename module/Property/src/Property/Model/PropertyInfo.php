<?php namespace Property\Model;

class PropertyInfo{
    public $property_id;
	public $bedrooms;
    public $bathrooms;
    public $property_taxes;
	public $hoa_fees;

	/**
     * returns the property_id of the property
     *
     * @return int
     */
    public function getProperty_id(){
        return $this->property_id;
    }

    /**
     * @param int $property_id
     */
    public function setProperty_id($property_id){
        $this->property_id = (int) $property_id;
    }

    /**
     * returns the bedrooms of the property
     *
     * @return int
     */
    public function getBedrooms(){
        return $this->bedrooms;
    }

    /**
     * @param int $bedrooms
     */
    public function setBedrooms($bedrooms){
        $this->bedrooms = (int) $bedrooms;
    }

    /**
     * returns the bathrooms of the property
     *
     * @return float
     */
    public function getBathrooms(){
        return $this->bathrooms;
    }

    /**
     * @param float $bathrooms
     */
    public function setBathrooms($bathrooms){
        $this->bathrooms = (float) $bathrooms;
    }

    /**
     * returns the taxes of the property
     *
     * @return float
     */
    public function getProperty_taxes(){
        return $this->property_taxes;
    }

    /**
     * @param float $property_taxes
     */
    public function setProperty_taxes($property_taxes){
        $this->property_taxes = (float) $property_taxes;
    }

    /**
     * returns the hoa_fees of the property
     *
     * @return float
     */
    public function getHoa_fees(){
        return $this->hoa_fees;
    }

    /**
     * @param float $hoa_fees
     */
    public function setHoa_fees($hoa_fees){
        $this->hoa_fees = (float) $hoa_fees;
    }
}