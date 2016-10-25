<?php namespace Landlord\Entity;

class Tenant{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $authorId;
    
    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
	public $middleInitial;
	
    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $birthDate;
	
    /**
     * @var string
     */
    public $code;

	/**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Tenant
     */
    public function setId($int){
        $this->id = (int) $int;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(){
        return $this->authorId;
    }

    /**
     * @param int $int
     * @return Tenant
     */
    public function setAuthorId($int){
        $this->authorId = (int) $int;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(){
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getMiddleInitial(){
        return $this->middleInitial;
    }

    /**
     * @return string
     */
    public function getLastName(){
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getBirthDate(){
        return $this->birthDate;
    }

    /**
     * @return string
     */
    public function getCode(){
        return $this->code;
    }
}