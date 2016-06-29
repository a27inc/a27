<?php namespace Property\Entity;

class Description{
    /**
     * @var int
     */
    public $propertyId;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var string
     */
    public $notes;

    /**
     * @return int
     */
    public function getPropertyId(){
        return $this->propertyId;
    }

    /**
     * @return int
     */
    public function getSummary(){
        return $this->summary;
    }

    /**
     * @return int
     */
    public function getNotes(){
        return $this->notes;
    }
}