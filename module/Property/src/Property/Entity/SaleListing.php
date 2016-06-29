<?php namespace Property\Entity;

use Application\Entity\EntityAbstract;

class SaleListing extends EntityAbstract{
    /**
     * @var int
     */
    public $propertyId;

    /**
     * @var float
     */
    public $rent;

    /**
     * @var float
     */
    public $deposit;

    /**
     * @var string
     */
    public $contactName;

    /**
     * @var string
     */
    public $contactNumber;

    /**
     * @var string
     */
    public $summary;
    
    /**
     * @var string
     */
    public $notes;

    /**
     * @var string
     */
    public $ctaButton;
    
    /**
     * @var string
     */
    public $ctaTitle;

    /**
     * @var string
     */
    public $ctaMessage;
    
    /**
     * @var string
     */
    public $ctaFooter;

    /**
     * @return int
     */
    public function getPropertyId(){
        return $this->propertyId;
    }

    /**
     * @param int $int
     * @return SaleListing
     */
    public function setPropertyId($int){
        $this->propertyId = (int) $int;
        return $this;
    }

    /**
     * @return float
     */
    public function getRent(){
        return $this->rent;
    }

    /**
     * @param float $rent
     * @return SaleListing
     */
    public function setRent($rent){
        $this->rent = (float) $rent;
        return $this;
    }

    /**
     * @return float
     */
    public function getDeposit(){
        return $this->deposit;
    }

    /**
     * @param float $deposit
     * @return SaleListing
     */
    public function setDeposit($deposit){
        $this->deposit = (float) $deposit;
        return $this;
    }

    /**
     * @return string
     */
    public function getContactName(){
        return $this->contactName;
    }

    /**
     * @param string $str
     * @return SaleListing
     */
    public function setContactName($str){
        $this->contactName = (string) $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getContactNumber(){
        return $this->contactNumber;
    }

    /**
     * @param string $str
     * @return SaleListing
     */
    public function setContactNumber($str){
        $this->contactNumber = (string) $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary(){
        return $this->summary;
    }

    /**
     * @param string $str
     * @return SaleListing
     */
    public function setSummary($str){
        $this->summary = (string) $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotes(){
        return $this->notes;
    }

    /**
     * @param string $str
     * @return SaleListing
     */
    public function setNotes($str){
        $this->notes = (string) $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getCtaButton(){
        return $this->ctaButton;
    }

    /**
     * @param string $str
     * @return SaleListing
     */
    public function setCtaButton($str){
        $this->ctaButton = (string) $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getCtaTitle(){
        return $this->ctaTitle;
    }

    /**
     * @param string $str
     * @return SaleListing
     */
    public function setCtaTitle($str){
        $this->ctaTitle = (string) $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getCtaMessage(){
        return $this->ctaMessage;
    }

    /**
     * @param string $str
     * @return SaleListing
     */
    public function setCtaMessage($str){
        $this->ctaMessage = (string) $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getCtaFooter(){
        return $this->ctaFooter;
    }

    /**
     * @param string $str
     * @return SaleListing
     */
    public function setCtaFooter($str){
        $this->ctaFooter = (string) $str;
        return $this;
    }
}