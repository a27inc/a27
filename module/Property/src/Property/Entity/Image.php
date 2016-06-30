<?php namespace Property\Entity;

use Application\Entity\EntityAbstract;

class Image extends EntityAbstract{
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
    public $description;

    /**
     * @var string
     */
    public $file;

    /**
     * @var string
     */
    protected $dir = '/images/property/';

    /**
     * @var string
     */
    protected $thumb_dir = '/images/property/thumbs/';

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
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
    public function getDescription(){
        return $this->description;
    }

    /**
     * @return string
     */
    public function getFile($thumb = false){
        return ($thumb ? $this->thumb_dir : $this->dir).$this->file;
    }
}