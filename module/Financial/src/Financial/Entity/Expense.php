<?php namespace Financial\Entity;

use Financial\Model\Financial;
use Property\Entity\Property;

class Expense extends Financial{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $authorId;

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
    public $dateFiled;

    /**
     * @var string
     */
    public $dateFrom;

    /**
     * @var string
     */
    public $dateTo;

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
    protected $total;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Expense
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
     * @return Expense
     */
    public function setAuthorId($int){
        $this->authorId = (int) $int;
        return $this;
    }

    /**
     * @return Property
     */
    public function getProperty(){
        return $this->property;
    }

    /**
     * @param Property $obj
     * @return Expense
     */
    public function setProperty(Property $obj){
        $this->property = $obj;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     * @param Category $obj
     * @return Expense
     */
    public function setCategory(Category $obj){
        $this->category = $obj;
        return $this;
    }

    /**
     * @return Rate
     */
    public function getRate(){
        return $this->rate;
    }

    /**
     * @param Rate $obj
     * @return Expense
     */
    public function setRate(Rate $obj){
        $this->rate = $obj;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(){
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDateFiled(){
        return $this->dateFiled;
    }

    /**
     * @return string
     */
    public function getDateFrom(){
        return $this->dateFrom;
    }

    /**
     * @return string
     */
    public function getDateTo(){
        return $this->dateTo;
    }

    /**
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $end
     * @param string $start
     * @return float
     */
    public function getTotal($end = NULL, $start = NULL){
        if(!$this->total)
            $this->setTotal($end, $start);
        return $this->total;
    }

    /**
     * @param string $end
     * @param string $start
     * @return Expense
     */
    private function setTotal($end, $start){
        $this->total = parent::getFinanceTotal($this, $end, $start);
        return $this;
    }
}