<?php namespace SiteUser\Entity;

use SiteUser\Entity\UserRole;

class User{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $email;

    /**
     * @var int
     */
    public $displayname;

    /**
     * @var UserRole
     */
    public $role;

    // prevent hydrating with similar fields from other tables
    private $hydrator_flag = array(
        'id' => false);

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
    public function setUser_id($id){
        $this->hydrator_flag['id'] = true;
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email){
        $this->email = (string) $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayname(){
        return $this->displayname;
    }

    /**
     * @param string $displayname
     */
    public function setDisplayname($displayname){
        $this->displayname = (string) $displayname;
        return $this;
    }

    /**
     * @param UserRole
     */
    public function getRole(){
        return $this->role;
    }

    /**
     * @return UserRole $role
     */
    public function setRole(UserRole $role){
        $this->role = $role;
        return $this;
    }
}