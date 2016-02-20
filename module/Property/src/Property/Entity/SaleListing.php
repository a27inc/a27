<?php namespace Property\Entity;

class SaleListing{
    /**
     * @var int
     */
    public $property_id;

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
    public $contact_name;

    /**
     * @var string
     */
    public $contact_number;

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
    public $cta_button;
    
    /**
     * @var string
     */
    public $cta_title;

    /**
     * @var string
     */
    public $cta_message;
    
    /**
     * @var string
     */
    public $cta_footerRent;

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
     * @return float
     */
    public function getRent(){
        return $this->rent;
    }

    /**
     * @param float $rent
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
     */
    public function setDeposit($deposit){
        $this->deposit = (float) $deposit;
        return $this;
    }

    /**
     * @return string
     */
    public function getContact_name(){
        return $this->contact_name;
    }

    /**
     * @param string $contact_name
     */
    public function setContact_name($contact_name){
        $this->contact_name = (string) $contact_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getContact_number(){
        return $this->contact_number;
    }

    /**
     * @param string $contact_number
     */
    public function setContact_number($contact_number){
        $this->contact_number = (string) $contact_number;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary(){
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary){
        $this->summary = (string) $summary;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotes(){
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes){
        $this->notes = (string) $notes;
        return $this;
    }

    /**
     * @return string
     */
    public function getCta_button(){
        return $this->cta_button;
    }

    /**
     * @param string $cta_button
     */
    public function setCta_button($cta_button){
        $this->cta_button = (string) $cta_button;
        return $this;
    }

    /**
     * @return string
     */
    public function getCta_title(){
        return $this->cta_title;
    }

    /**
     * @param string $cta_title
     */
    public function setCta_title($cta_title){
        $this->cta_title = (string) $cta_title;
        return $this;
    }

    /**
     * @return string
     */
    public function getCta_message(){
        return $this->cta_message;
    }

    /**
     * @param string $cta_message
     */
    public function setCta_message($cta_message){
        $this->cta_message = (string) $cta_message;
        return $this;
    }

    /**
     * @return string
     */
    public function getCta_footer(){
        return $this->cta_footer;
    }

    /**
     * @param string $cta_footer
     */
    public function setCta_footer($cta_footer){
        $this->cta_footer = (string) $cta_footer;
        return $this;
    }
}