<?php namespace Financial\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class RatesTable  extends AbstractTableGateway{
    protected $table = 'rates';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Rate());
        $this->initialize();
    }

    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getRate($id){
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if(!$row)
            throw new \Exception("Could not find row $id");
        return $row;
    }

    public function getOptions(){
        $rates = $this->fetchAll();
        $options = array();
        foreach($rates as $rate)
            $options[$rate->id] = $rate->name;
        return $options;
    }

    public function saveRate(Rate $rate){
        $data = array(
            'name'    => $rate->name,
            'monthly'      => $rate->monthly,
            'quarterly'    => $rate->quarterly,
            'semi_anual'   => $rate->semi_anual,
            'anual'        => $rate->anual,
        );

        $id = (int) $rate->id;
        if($id == 0)
            $this->insert($data);
        else{
            if($this->getRate($id))
                $this->update($data, array('id' => $id));
            else
                throw new \Exception('Rate id does not exist!');
        }
    }

    public function deleteRate($id){
        $this->delete(array('id' => (int) $id));
    }
}