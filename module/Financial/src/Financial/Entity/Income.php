<?php namespace Financial\Entity;

use Property\Entity\Property;
use Financial\Model\Financial;

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
     * @return Income
     */
    public function setId($int){
        $this->id = (int) $int;
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
     * @return Income
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
     * @return Income
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
     * @return Income
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
     * @param string $end Y-m-d
     * @param string $start Y-m-d
     * @return float
     */
    public function getTotal($end = NULL, $start = NULL){
        if(!$this->total)
            $this->setTotal($end, $start);
        return $this->total;
    }

    /**
     * sets the total for recurring expenses
     *
     * @param string $end Y-m-d
     * @param string $start Y-m-d
     * @return Income
     */
    private function setTotal($end, $start){
        $this->total = parent::getFinanceTotal($this, $end, $start);
        return $this;
    }
}