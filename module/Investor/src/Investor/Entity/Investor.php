<?php namespace Investor\Entity;

use SiteUser\Entity\User;
use Application\Entity\EntityAbstract;

class Investor extends EntityAbstract{

    public static $NOTIFICATION_FREQUENCY_NONE      = 0;
    public static $NOTIFICATION_FREQUENCY_DAILY     = 1;
    public static $NOTIFICATION_FREQUENCY_WEEKLY    = 2;
    public static $NOTIFICATION_FREQUENCY_MONTHLY   = 3;
    public static $NOTIFICATION_FREQUENCY_QUARTERLY = 4;

    public static $NOTIFICATION_FREQUENCY_NAMES = array(
        0 => 'Never',
        1 => 'Daily',
        2 => 'Weekly',
        3 => 'Monthly',
        4 => 'Quarterly');

    /**
     * @var int
     */
    protected $id;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var int
     */
    protected $financialNotificationFrequency;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $int
     * @return Investor
     */
    public function setId($int){
        $this->id = (int) $int;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @param User $obj
     * @return Investor
     */
    public function setUser($obj){
        $this->user = $obj;
        return $this;
    }

    /**
     * @return int
     */
    public function getFinancialNotificationFrequency(){
        return $this->financialNotificationFrequency;
    }

    /**
     * @param int $id
     * @return Investor
     */
    public function setFinancialNotificationFrequency($id){
        $this->financialNotificationFrequency = $id;
        return $this;
    }

    public function getNotificationFrequencyName(){
        if(isset(static::$NOTIFICATION_FREQUENCY_NAMES[$this->getFinancial_notification_frequency()]))
            return static::$NOTIFICATION_FREQUENCY_NAMES[$this->getFinancial_notification_frequency()];
        return static::$NOTIFICATION_FREQUENCY_NAMES[static::$NOTIFICATION_FREQUENCY_NONE];
    }
}