<?php namespace Landlord\Entity;

class Tenant{
    /**
     * @var int
     */
    public $id;
    
    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
	public $middle_initial;
	
    /**
     * @var string
     */
    public $last_name;
	
    /**
     * @var string
     */
    public $code;

    // prevent hydrating with similar fields from other tables
    private $hydrator_flag = array(
        'id' => false);

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
            $this->id = (int) $id;
        return $this;
    }

    /**
     * @param int $id
     */
    public function setTenant_id($id){
        $this->hydrator_flag['id'] = true;
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirst_name(){
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirst_name($name){
        $this->first_name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getMiddle_initial(){
        return $this->middle_initial;
    }

    /**
     * @param string $middle_initial
     */
    public function setMiddle_initial($initial){
        $this->middle_initial = $initial;
        return $this;
    }

    /**
     * @return string
     */
    public function getLast_name(){
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLast_name($name){
        $this->last_name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(){
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code){
        $this->code = $code;
        return $this;
    }
}