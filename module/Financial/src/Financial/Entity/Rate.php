<?php namespace Financial\Entity;

class Rate{
    /**
     * @var int
     */
    protected $id; 
    
    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $monthly;

    /**
     * @var float
     */
    protected $quarterly;

    /**
     * @var float
     */
    protected $semi_anual;

    /**
     * @var float
     */
    protected $anual;

    // prevent hydrating with similar fields from other tables
    private $hydrator_flag = array(
        'id' => false,
        'name' => false);

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id){
        if(!$this->hydrator_flag['id'])
            $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getRate_id(){
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setRate_id($id){
        $this->hydrator_flag['id'] = true;
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name){
        if(!$this->hydrator_flag['name'])
            $this->name = $name;
        return $this;
    }

    /**
     * @param string $name
     */
    public function setRate_name($name){
        $this->hydrator_flag['name'] = true;
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getMonthly(){
        return $this->monthly;
    }

    /**
     * @param float $monthly
     */
    public function setMonthly($monthly){
        $this->monthly = $monthly;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuarterly(){
        return $this->quarterly;
    }

    /**
     * @param float $quarterly
     */
    public function setQuarterly($quarterly){
        $this->quarterly = $quarterly;
        return $this;
    }

    /**
     * @return float
     */
    public function getSemi_anual(){
        return $this->semi_anual;
    }

    /**
     * @param float $semi_annual
     */
    public function setSemi_anual($semi_anual){
        $this->semi_anual = $semi_anual;
        return $this;
    }

    /**
     * @return float
     */
    public function getAnual(){
        return $this->anual;
    }

    /**
     * @param float $annual
     */
    public function setAnual($anual){
        $this->anual = $anual;
        return $this;
    }
}