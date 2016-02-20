<?php namespace Financial\Entity;

class Category{
    /**
     * @var int
     */
    protected $id; 

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $display_name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $note;

    /**
     * @var int
     */
    protected $excl_cash_flow;

    /**
     * @var int
     */
    protected $excl_all;

    // prevent hydrating with similar fields from other tables
    private $hydrator_flag = array(
        'id' => false,
        'name' => false,
        'display_name' => false,
        'description' => false,
        'note' => false);

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
    public function getCategory_id(){
        return $this->id;
    }

    /**
     * @param int $category_id
     */
    public function setCategory_id($id){
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
    public function setCategory_name($name){
        $this->hydrator_flag['name'] = true;
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplay_name(){
        return $this->display_name;
    }

    /**
     * @param string $display_name
     */
    public function setDisplay_name($display_name){
        if(!$this->hydrator_flag['display_name'])
            $this->display_name = $display_name;
        return $this;
    }

    /**
     * @param string $display_name
     */
    public function setCategory_display_name($display_name){
        $this->hydrator_flag['display_name'] = true;
        $this->display_name = $display_name;
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
            $this->description = $description;
        return $this;
    }

    /**
     * @param string $description
     */
    public function setCategory_description($description){
        $this->hydrator_flag['description'] = true;
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note){
        if(!$this->hydrator_flag['note'])
            $this->note = $note;
        return $this;
    }

    /**
     * @param string $note
     */
    public function setCategory_note($note){
        $this->hydrator_flag['note'] = true;
        $this->note = $note;
        return $this;
    }

    /**
     * @return int
     */
    public function getExcl_cash_flow(){
        return $this->excl_cash_flow;
    }

    /**
     * @param int $excl_cash_flow
     */
    public function setExcl_cash_flow($v){
        $this->excl_cash_flow = (int) $v;
        return $this;
    }

    /**
     * @return int
     */
    public function getExcl_all(){
        return $this->excl_all;
    }

    /**
     * @param int $excl_all
     */
    public function setExcl_all($v){
        $this->excl_all = (int) $v;
        return $this;
    }
}