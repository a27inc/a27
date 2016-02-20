<?php namespace SiteUser\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class UsersTable extends AbstractTableGateway{
    protected $table = 'user';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new User());
        $this->initialize();
    }

    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getOptions(){
        $users = $this->fetchAll();
        $options = array();
        foreach($users as $u){
            //var_dump($u); die;
            $options[$u->id] = $u->displayName.' - '.$u->email;
        }return $options;
    }
}