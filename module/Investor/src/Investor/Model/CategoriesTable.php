<?php namespace Investor\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class CategoriesTable extends AbstractTableGateway{
    protected $table = 'allocation_categories';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Category());
        $this->initialize();
    }

    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getOptions(){
        $categories = $this->fetchAll();
        $options = array();
        foreach($categories as $cat){
            $options[$cat->id] = $cat->displayName;
        } return $options;
    }
}