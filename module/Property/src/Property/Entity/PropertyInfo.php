<?php namespace Property\Entity;

class PropertyInfo{
    /**
     * @var int
     */
    public $property_id;

    /**
     * @var int
     */
    public $sqft;

    /**
     * @var int
     */
    public $bedrooms;

    /**
     * @var float
     */
    public $bathrooms;

    /**
     * @var float
     */
    public $property_taxes;
    
    /**
     * @var float
     */
    public $hoa_fees;

    /**
     * @var int
     */
    public $year_built;

    /**
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
        return $this;
    }

    /**
     * @return int
     */
    public function getSqft(){
        return $this->sqft;
    }

    /**
     * @param int $sqft
     */
    public function setSqft($sqft){
        $this->sqft = (int) $sqft;
        return $this;
    }

    /**
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
        return $this;
    }

    /**
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
        return $this;
    }

    /**
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
        return $this;
    }

    /**
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
        return $this;
    }

    /**
     * @return int
     */
    public function getYear_built(){
        return $this->year_built;
    }

    /**
     * @param int $year_built
     */
    public function setYear_built($year_built){
        $this->year_built = (int) $year_built;
        return $this;
    } 
}