<?php namespace Financial\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;

//use Financial\Entity\Expense as Entity;
//use Zend\Db\Adapter\Driver\ResultInterface;
//use Zend\Stdlib\Hydrator\ClassMethods;

class ExpensesTable extends AbstractTableGateway{
    protected $table = 'expenses';
    //protected $hydrator;

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Expense());
        $this->initialize();
        //$this->hydrator = new ClassMethods(FALSE);
    }

    // TODO: Rewrite/Confirm
    public function fetchAll($from = NULL, $to = NULL){
        if($from || $to){
            $select = $this->sql->select(array('e' => 'expenses'));
            if($from && $to)
                $select->where->between('e.date_filed', $from, $to)
                    ->nest->lessThan('e.date_from', $to)
                    ->and->greaterThan('e.date_to', $from)->unest;
            elseif($from) $select->where(array('e.date_filed >= ?' => $from));
            elseif($to) $select->where(array('e.date_filed <= ?' => $to));  
            return $this->executeSelect($select);
            /*$stmt   = $this->sql->prepareStatementForSqlObject($select);
            $result = $stmt->execute();
            if($result instanceof ResultInterface && $result->isQueryResult()){
                $entity = new Entity();
                $resultSet = new HydratingResultSet($this->hydrator, $entity);
                
                return $resultSet->initialize($result);
            }*/
        } $resultSet = $this->select();
        return $resultSet;
    }

    public function getExpense($id){
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if(!$row)
            throw new \Exception("Could not find row $id");
        return $row;
    }

    public function saveExpense(Expense $expense){
        $data = array(
            'property_id'   => $expense->property_id,
            'category_id'   => $expense->category_id,
            'rate_id'       => $expense->rate_id,
            'amount'        => $expense->amount,
            'date_filed'    => $expense->date_filed,
            'date_from'     => $expense->date_from,
            'date_to'       => $expense->date_to,
            'description'   => $expense->description,
            'note'          => $expense->note,
        );

        $id = (int) $expense->getId();
        if($id == 0)
            $this->insert($data);
        else{
            if($this->getExpense($id))
                $this->update($data, array('id' => $id));
            else
                throw new \Exception('Expense id does not exist!');
        }
    }

    public function deleteExpense($id){
        $this->delete(array('id' => (int) $id));
    }
}