<?php namespace Property\Entity;

use Property\Entity\PropertyInfo; 
use Property\Entity\RentalListing; 
use Property\Entity\SaleListing; 

class Property{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $zpid;

    /**
     * @var int
     */
    public $status_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $street_address;

    /**
     * @var string
     */
    public $unit;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $state;

    /**
     * @var int
     */
    public $zip;

    /**
     * @var PropertyInfo
     */
    public $info;

    /**
     * @var array
     */
    public $images;

    /**
     * @var array
     */
    public $features;

    /**
     * @var array
     */
    public $amenities;

    /**
     * @var array
     */
    public $includes;

    /**
     * @var RentalListing
     */
    public $rental_listing;

    /**
     * @var SaleListing
     */
    public $sale_listing;

    // prevent hydrating with similar fields from other tables
    private $hydrator_flag = array(
        'id' => false,
        'name' => false);

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
    }

    /**
     * @param int $id
     */
    public function setProperty_id($id){
        $this->hydrator_flag['id'] = true;
        $this->id = (int) $id;
    }

    /**
     * @return int
     */
    public function getZpid(){
        return $this->zpid;
    }

    /**
     * @param int $zpid
     */
    public function setZpid($zpid){
        $this->zpid = (int) $zpid;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus_id(){
        return $this->status_id;
    }

    /**
     * @param int $status_id
     */
    public function setStatus_id($status_id){
        $this->status_id = (int) $status_id;
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
    public function setProperty_name($name){
        $this->hydrator_flag['name'] = true;
        $this->name = $name;
        return $this;
    }

    /**
     * returns the street of the property
     *
     * @return string
     */
    public function getStreet_address(){
        return $this->street_address;
    }

    /**
     * @param string $street_address
     */
    public function setStreet_address($street_address){
        $this->street_address = $street_address;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnit(){
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit){
        $this->unit = $unit;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(){
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city){
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(){
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state){
        $this->state = $state;
        return $this;
    }

    /**
     * @return int
     */
    public function getZip(){
        return $this->zip;
    }

    /**
     * @param int $zip
     */
    public function setZip($zip){
        $this->zip = (int) $zip;
        return $this;
    }

    /**
     * @return PropertyInfo
     */
    public function getInfo(){
        return $this->info;
    }

    /**
     * @param PropertyInfo $property_info
     * @return Property
     */
    public function setInfo(PropertyInfo $info){
        $this->info = $info;
        return $this;
    }

    /**
     * @return array
     */
    public function getImages(){
        return $this->images;
    }

    /**
     * @param array $images
     * @return Property
     */
    public function setImages(array $images){
        $this->images = $images;
        return $this;
    }

    /**
     * @return array
     */
    public function getFeatures(){
        return $this->features;
    }

    /**
     * @param array $features
     * @return Property
     */
    public function setFeatures(array $features){
        $this->features = $features;
        return $this;
    }

    /**
     * @return array
     */
    public function getAmenities(){
        return $this->amenities;
    }

    /**
     * @param array $amenities
     * @return Property
     */
    public function setAmenities(array $amenities){
        $this->amenities = $amenities;
        return $this;
    }

    /**
     * @return array
     */
    public function getIncludes(){
        return $this->includes;
    }

    /**
     * @param array $includes
     * @return Property
     */
    public function setIncludes(array $includes){
        $this->includes = $includes;
        return $this;
    }

    /**
     * @return RentalListing
     */
    public function getRental_listing(){
        return $this->rental_listing;
    }

    /**
     * @param RentalListing $rental_listing
     * @return Property
     */
    public function setRental_listing(RentalListing $rental_listing){
        $this->rental_listing = $rental_listing;
        return $this;
    }

    /**
     * @return SaleListing
     */
    public function getSale_listing(){
        return $this->sale_listing;
    }

    /**
     * @param SaleListing $sale_listing
     * @return Property
     */
    public function setSale_listing(SaleListing $sale_listing){
        $this->sale_listing = $sale_listing;
        return $this;
    }
}