<?php namespace Financial\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

//use Financial\Entity\Income as Entity;
//use Zend\Db\Adapter\Driver\ResultInterface;
//use Zend\Hydrator\ClassMethods;

class IncomesTable extends AbstractTableGateway{
    protected $table = 'incomes';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Income());
        $this->initialize();
    }

    // TODO: Rewrite/Confirm
    public function fetchAll($from = NULL, $to = NULL){
        if($from && $to){
            $select = $this->sql->select(array('e' => 'incomes'));
            if($from && $to)
                $select->where->between('e.date_filed', $from, $to)
                    ->nest->lessThan('e.date_from', $to)
                    ->and->greaterThan('e.date_to', $from)->unest;
            elseif($from) $select->where(array('e.date_filed >= ?' => $from));
            elseif($to) $select->where(array('e.date_filed <= ?' => $to));   
            return $this->executeSelect($select);
            /*$stmt = $this->sql->prepareStatementForSqlObject($select);
            $result = $stmt->execute();
            if($result instanceof ResultInterface && $result->isQueryResult()){
                $entity = new Entity();
                $resultSet = new HydratingResultSet($this->hydrator, $entity);
                
                return $resultSet->initialize($result);
            }*/
        } $resultSet = $this->select();
        return $resultSet;
    }

    public function getIncome($id){
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if(!$row)
            throw new \Exception("Could not find row $id");
        return $row;
    }

    public function saveIncome(Income $income){
        $data = array(
            'author_id'     => $income->author_id,
            'property_id'   => $income->property_id,
            'category_id'   => $income->category_id,
            'rate_id'       => $income->rate_id,
            'amount'        => $income->amount,
            'date_filed'    => $income->date_filed,
            'date_from'     => $income->date_from,
            'date_to'       => $income->date_to,
            'description'   => $income->description,
            'note'          => $income->note
        );

        $id = (int) $income->getId();
        if($id == 0)
            $this->insert($data);
        else{
            if($this->getIncome($id))
                $this->update($data, array('id' => $id));
            else
                throw new \Exception('Income id does not exist!');
        }
    }

    public function deleteIncome($id){
        $this->delete(array('id' => (int) $id));
    }
}