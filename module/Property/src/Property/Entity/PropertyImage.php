<?php namespace Property\Entity;

class PropertyImage{
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
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $file;

    /**
     * @var int
     */
    public $remove;

    // prevent hydrating with similar fields from other tables
    private $hydrator_flag = array(
        'id' => false,
        'name' => false,
        'description' => false);

    /**
     * @var string
     */
    public $dir = '/images/property/';

    /**
     * @var string
     */
    public $thumb_dir = '/images/property/thumbs/';

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
    public function setImage_id($id){
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
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name){
        if(!$this->hydrator_flag['name'])
            $this->name = (string) $name;
        return $this;
    }

    /**
     * @param string $name
     */
    public function setImage_name($name){
        $this->hydrator_flag['name'] = true;
            $this->name = (string) $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description){
        if(!$this->hydrator_flag['description'])
            $this->description = (string) $description;
        return $this;
    }

    /**
     * @param string $description
     */
    public function setImage_description($description){
        $this->hydrator_flag['description'] = true;
        $this->description = (string) $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getFile(){
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file){
        $this->file = (string) $file;
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