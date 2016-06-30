<?php namespace Property\Entity;

use Application\Entity\EntityAbstract;

class RentalListing extends EntityAbstract{

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
    public $available;

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
     * @return float
     */
    public function getRent(){
        return $this->rent;
    }

    /**
     * @return float
     */
    public function getDeposit(){
        return $this->deposit;
    }

    /**
     * @return string
     */
    public function getAvailable(){
        return $this->available;
    }

    /**
     * @return string
     */
    public function getContactName(){
        return $this->contactName;
    }

    /**
     * @return string
     */
    public function getContactNumber(){
        return $this->contactNumber;
    }

    /**
     * @return string
     */
    public function getSummary(){
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getNotes(){
        return $this->notes;
    }

    /**
     * @return string
     */
    public function getCtaButton(){
        return $this->ctaButton;
    }

    /**
     * @return string
     */
    public function getCtaTitle(){
        return $this->ctaTitle;
    }

    /**
     * @return string
     */
    public function getCtaMessage(){
        return $this->ctaMessage;
    }

    /**
     * @return string
     */
    public function getCtaFooter(){
        return $this->ctaFooter;
    }
}