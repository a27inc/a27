<?php namespace Financial\Entity;

class Rate{
    /**
     * @var int
     */
    public $id;
    
    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $monthly;

    /**
     * @var float
     */
    public $quarterly;

    /**
     * @var float
     */
    public $semiAnnual;

    /**
     * @var float
     */
    public $annual;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Rate
     */
    public function setId($int){
        $this->id = (int) $int;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @return float
     */
    public function getMonthly(){
        return $this->monthly;
    }

    /**
     * @return float
     */
    public function getQuarterly(){
        return $this->quarterly;
    }

    /**
     * @return float
     */
    public function getSemiAnnual(){
        return $this->semiAnnual;
    }

    /**
     * @return float
     */
    public function getAnnual(){
        return $this->annual;
    }
}