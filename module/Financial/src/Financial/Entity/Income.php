<?php namespace Financial\Entity;

use Financial\Model\Financial;
use Property\Entity\Property;
use Financial\Entity\Category;
use Financial\Entity\Rate;

class Income extends Financial{
    /**
     * @var int
     */
    public $id;

    /**
     * @var Property
     */
    public $property; 

    /**
     * @var Category
     */
    public $category;

    /**
     * @var Rate
     */
    public $rate;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $date_filed;

    /**
     * @var string
     */
    public $date_from;

    /**
     * @var string
     */
    public $date_to;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $note;

    /**
     * @var float
     */
    public $total;

    // prevent hydrating with similar fields from other tables
    private $hydrator_flag = array(
        'id' => false,
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
     * @param int $id
     */
    public function setIncome_id($id){
        $this->hydrator_flag['id'] = true;
        $this->id = $id;
        return $this;
    }

    /**
     * @return Property
     */
    public function getProperty(){
        return $this->property;
    }

    /**
     * @param Property $property
     */
    public function setProperty(Property $property){
        $this->property = $property;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category){
        $this->category = $category;
        return $this;
    }

    /**
     * @return Rate
     */
    public function getRate(){
        return $this->rate;
    }

    /**
     * @param Rate $rate
     */
    public function setRate(Rate $rate){
        $this->rate = $rate;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(){
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount){
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate_filed(){
        return $this->date_filed;
    }

    /**
     * @param string $date_filed
     */
    public function setDate_filed($date_filed){
        $this->date_filed = $date_filed;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate_from(){
        return $this->date_from;
    }

    /**
     * @param string $date_from
     */
    public function setDate_from($date_from){
        $this->date_from = $date_from;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate_to(){
        return $this->date_to;
    }

    /**
     * @param string $date_to
     */
    public function setDate_to($date_to){
        $this->date_to = $date_to;
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
    public function setIncome_description($description){
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
    public function setIncome_note($note){
        $this->hydrator_flag['note'] = true;
        $this->note = $note;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal($end = NULL, $start = NULL){
        if(!$this->total)
            $this->setTotal($end, $start);
        return $this->total;
    }

    /**
     * sets the total for recurring expenses
     */
    private function setTotal($end, $start){
        $this->total = parent::getFinanceTotal($this, $end, $start);
        return $this;
    }
}