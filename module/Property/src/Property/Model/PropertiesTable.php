<?php namespace Property\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class PropertiesTable extends AbstractTableGateway{
    protected $table = 'properties';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Property());
        $this->initialize();
    }

    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getOptions(){
        $properties = $this->fetchAll();
        $options = array();
        foreach($properties as $p){
            $options[$p->id] = $p->name;
        }return $options;
    }
}