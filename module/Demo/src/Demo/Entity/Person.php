<?php namespace Demo\Entity;

class Person{
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
    public $last_name;

    /**
     * @var string
     */
    public $birth_date;
	
    /**
     * @var int
     */
    public $post_code;

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
    public function setPerson_id($id){
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
    public function getBirth_date(){
        return $this->birth_date;
    }

    /**
     * @param string $birth_date
     */
    public function setBirth_date($date){
        $this->birth_date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getPost_code(){
        return $this->post_code;
    }

    /**
     * @param int $post_code
     */
    public function setPost_code($code){
        $this->post_code = $code;
        return $this;
    }
}