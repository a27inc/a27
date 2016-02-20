<?php namespace Investor\Entity;

use SiteUser\Entity\User;
use Property\Entity\Property;

class Allocation{
    /**
     * @var int
     */
    protected $id; 

    /**
     * @var User
     */
    protected $investor;

    /**
     * @var AllocationCategory
     */
    protected $category;

    /**
     * @var Property
     */
    protected $property;

    /**
     * @var float
     */
    protected $allocation;

    /**
     * @var string
     */
    protected $note;

    // prevent hydrating with similar fields from other tables
    private $hydrator_flag = array(
        'id' => false,
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
    public function setAllocation_id($id){
        $this->hydrator_flag['id'] = true;
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getInvestor(){
        return $this->investor;
    }

    /**
     * @param User $user
     */
    public function setInvestor(User $user){
        $this->investor = $user;
        return $this;
    }

    /**
     * @return AllocationCategory
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     * @param AllocationCategory $category
     */
    public function setCategory(Category $category){
        $this->category = $category;
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
     * @return string
     */
    public function getAllocation(){
        return $this->allocation;
    }

    /**
     * @param string $allocation
     */
    public function setAllocation($allocation){
        $this->allocation = $allocation;
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
    public function setAllocation_note($note){
        $this->hydrator_flag['note'] = true;
        $this->note = $note;
        return $this;
    }
}