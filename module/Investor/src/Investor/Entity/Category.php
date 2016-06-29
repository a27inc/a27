<?php namespace Investor\Entity;

use Application\Entity\EntityAbstract;

class Category extends EntityAbstract{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $symbol;

    /**
     * @var string
     */
    public $displayName;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $note;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Category
     */
    public function setId($int){
        $this->id = (int) $int;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSymbol(){
        return $this->symbol;
    }

    /**
     * @return string
     */
    public function getDisplayName(){
        return $this->displayName;
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
}