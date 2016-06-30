<?php namespace Property\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ExtraTypesTable extends AbstractTableGateway{
    protected $table = 'extra_type';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Extra());
        $this->initialize();
    }

    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getOptions(){
        $rows = $this->fetchAll();
        $options = array();
        foreach($rows as $r){
            $options[$r->id] = $r->name;
        }return $options;
    }
}