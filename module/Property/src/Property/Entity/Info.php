<?php namespace Property\Entity;

class Info{

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
    public $propertyTaxes;
    
    /**
     * @var float
     */
    public $hoaFees;

    /**
     * @var int
     */
    public $yearBuilt;

    /**
     * @return int
     */
    public function getSqft(){
        return $this->sqft;
    }

    /**
     * @return int
     */
    public function getBedrooms(){
        return $this->bedrooms;
    }

    /**
     * @return float
     */
    public function getBathrooms(){
        return $this->bathrooms;
    }

    /**
     * @return float
     */
    public function getPropertyTaxes(){
        return $this->propertyTaxes;
    }

    /**
     * @return float
     */
    public function getHoaFees(){
        return $this->hoaFees;
    }

    /**
     * @return int
     */
    public function getYearBuilt(){
        return $this->yearBuilt;
    }
}