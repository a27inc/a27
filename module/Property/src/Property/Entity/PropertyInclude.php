<?php namespace Property\Entity;

class PropertyInclude{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $property_id;

    /**
     * @var string
     */
    public $include;

    /**
     * @var int
     */
    public $remove;

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
    public function setInclude_id($id){
        $this->hydrator_flag['id'] = true;
            $this->id = (int) $id;
        return $this;
    }

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
     * @return string
     */
    public function getInclude(){
        return $this->include;
    }

    /**
     * @param string $include
     */
    public function setInclude($include){
        $this->include = (string) $include;
        return $this;
    }

    /**
     * @return int
     */
    public function getRemove(){
        return $this->remove;
    }

    /**
     * @param int $remove
     */
    public function setRemove($remove){
        $this->remove = (int) $remove;
        return $this;
    }   
}