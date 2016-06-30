<?php namespace Property\Entity;

use Application\Entity\EntityAbstract;

class Property extends EntityAbstract{
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
    public $statusId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $streetAddress;

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
     * @var Info
     */
    public $info;

    /**
     * @var array
     */
    public $images = array();

    /**
     * @var array
     */
    protected $imageIds = array();

    /**
     * @var array
     */
    protected $featuresById = array();
    
    /**
     * @var array
     */
    protected $featuresByName = array();

    /**
     * @var array
     */
    protected $amenitiesById = array();

    /**
     * @var array
     */
    protected $amenitiesByName = array();

    /**
     * @var array
     */
    protected $includesById = array();

    /**
     * @var array
     */
    protected $includesByName = array();

    /**
     * @var array
     */
    protected $extraIds = array();

    /**
     * @var array
     */
    public $extras = array();

    /**
     * @var RentalListing
     */
    public $rentalListing;

    /**
     * @var SaleListing
     */
    public $saleListing;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Property
     */
    public function setId($int){
        $this->id = (int) $int;
        return $this;
    }

    /**
     * @return int
     */
    public function getZpid(){
        return $this->zpid;
    }

    /**
     * @return int
     */
    public function getStatusId(){
        return $this->statusId;
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
    public function getStreetAddress(){
        return $this->streetAddress;
    }

    /**
     * @return string
     */
    public function getUnit(){
        return $this->unit;
    }

    /**
     * @return string
     */
    public function getCity(){
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState(){
        return $this->state;
    }

    /**
     * @return int
     */
    public function getZip(){
        return $this->zip;
    }

    /**
     * @return Info
     */
    public function getInfo(){
        return $this->info;
    }

    /**
     * @param Info $obj
     * @return Property
     */
    public function setInfo(Info $obj){
        $this->info = $obj;
        return $this;
    }

    /**
     * @return array
     */
    public function getImages(){
        return $this->images;
    }

    /**
     * @param Image $obj
     * @return $this
     */
    public function addImage(Image $obj) {
        $this->images[$obj->getId()] = $obj;
        $this->imageIds[] = $obj->getId();
        return $this;
    }

    

    /**
     * @return array
     */
    public function getFeatures(){
        return array_keys($this->featuresByName);
    }

    /**
     * @return array
     */
    public function getFeatureIds() {
        return array_keys($this->featuresById);
    }

    /**
     * @return array
     */
    public function getAmenities(){
        return array_keys($this->amenitiesByName);
    }

    /**
     * @return array
     */
    public function getAmenityIds() {
        return array_keys($this->amenitiesById);
    }

    /**
     * @return array
     */
    public function getIncludes(){
        return array_keys($this->includesByName);
    }

    /**
     * @return array
     */
    public function getIncludeIds() {
        return array_keys($this->includesById);
    }

    /**
     * @param Extra $obj
     * @return $this
     */
    public function addExtra(Extra $obj) {
        $this->extras[$obj->getId()] = $obj;
        $this->extraIds[] = $obj->getId();
        if ($obj->getTypeId() == Extra::TYPE_AMENITY) {
            $this->amenitiesById[$obj->getId()] = $obj;  
            $this->amenitiesByName[$obj->getName()] = $obj;
        }
        else if ($obj->getTypeId() == Extra::TYPE_INCLUDE) {
            $this->includesById[$obj->getId()] = $obj;
            $this->includesByName[$obj->getName()] = $obj;
        }
        else if ($obj->getTypeId() == Extra::TYPE_FEATURE) {
            $this->featuresById[$obj->getId()] = $obj;
            $this->featuresByName[$obj->getName()] = $obj;
        }
        return $this;
    }

    /**
     * @param bool $fromForm retrieve 
     * @return array
     */
    public function getExtraIds($fromForm = false) {
        if ($fromForm) {
            $ids = array();
            // these are possibly new ids from the form
            foreach ($this->extras as $obj) {
                $ids[] = $obj->getId();
            }
            return $ids;
        }
        // these ids came directly from the database
        return $this->extraIds;
    }

    /**
     * @return RentalListing
     */
    public function getRentalListing(){
        return $this->rentalListing;
    }

    /**
     * @param RentalListing $obj
     * @return Property
     */
    public function setRentalListing(RentalListing $obj){
        $this->rentalListing = $obj;
        return $this;
    }

    /**
     * @return SaleListing
     */
    public function getSaleListing(){
        return $this->saleListing;
    }

    /**
     * @param SaleListing $obj
     * @return Property
     */
    public function setSaleListing(SaleListing $obj){
        $this->saleListing = $obj;
        return $this;
    }

    /**
     * Return meta description for property detail page
     *
     * @param int $maxLength maximum description length
     * @return string
     */
    public function getMetaDescription($maxLength = 160){
        $meta_desc = $this->getInfo()->getBedrooms().' bed '.
            $this->getInfo()->getBathrooms().' bath';

        switch($this->getStatusId()){
            case 1: $meta_desc .= ' condo for rent'; break;
            case 2: $meta_desc .= ' home for sale'; break;
        }

        $meta_desc .= ' in '.$this->getCity().', '.$this->getState().'.';

        $meta_amenities = $this->getAmenities()
            ? ' Amenities: ' . implode(', ', $this->getAmenities()) : '';
        if((strlen($meta_desc) + strlen($meta_amenities)) <= $maxLength)
            $meta_desc .= $meta_amenities;

        $metaFeatures = $this->getFeatures()
            ? ' Features: ' . implode(', ', $this->getFeatures()) : '';
        if((strlen($meta_desc) + strlen($metaFeatures)) <= $maxLength)
            $meta_desc .= $metaFeatures;

        $meta_includes = $this->getIncludes()
            ? ' Included: ' . implode(', ', $this->getIncludes()) : '';
        if((strlen($meta_desc) + strlen($meta_includes)) <= $maxLength)
            $meta_desc .= $meta_includes;

        return $meta_desc;
    }

    /**
     * Return Property address
     *
     * @param bool $includeUnit
     * @return string
     */
    public function getAddress($includeUnit = false){
        $address = $this->getStreetAddress();
        if($this->getUnit() && $includeUnit) 
            $address .= ' #'.$this->getUnit();
        $address .= ', '.$this->getCity();
        $address .= ', '.$this->getState();
        $address .= ' '.$this->getZip();
        return $address;
    }
}