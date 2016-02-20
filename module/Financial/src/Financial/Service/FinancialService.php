<?php namespace Financial\Service;

use Financial\Entity\Rate;
use Financial\Entity\Income;
use Financial\Entity\Expense;
use Financial\Entity\FinancialSummary;
use Property\Entity\Property;
use Financial\Entity\Category;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Stdlib\Hydrator\ClassMethods;

class FinancialService{
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    protected $category_entity;
    protected $expense_entity;
    protected $income_entity;
    protected $property_entity;

    public function __construct(AdapterInterface $dbAdapter){
        $this->dbAdapter = $dbAdapter;
        $this->hydrator  = new ClassMethods(FALSE);
    }

    public function getCategory($id){
        $categories = $this->getCategories('id = '.$id);
        return $categories->current();
    }

    public function getExpense($id){
        $expenses = $this->getExpenses('e.id = '.$id);
        return array_shift($expenses);
    }

    public function getIncome($id){
        $incomes = $this->getIncomes('i.id = '.$id);
        return array_shift($incomes);
    }

    public function getFinancialSummary($year = NULL, $property = NULL){
        $where = '';
        if($year) $where .= 'i.date_filed LIKE "'.$year.'%"';
        if($property) $where .= ' i.property_id = '.$property;
        $where = $where ? trim($where) : NULL;
        $incomes = $this->getIncomes($where);

        $where = '';
        if($year) $where .= 'e.date_filed LIKE "'.$year.'%"';
        if($property) $where .= ' e.property_id = '.$property;
        $where = $where ? trim($where) : NULL;
        $expenses = $this->getExpenses($where);

        $summary = new FinancialSummary();
        foreach($incomes as $i)
            $summary->addIncome($i);

        foreach($expenses as $e)
            $summary->addExpense($e);

        return $summary;
    }

    public function getCategories($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('c' => 'financial_categories'));

        if($where) $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $categories = array();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            $resultSet = new HydratingResultSet($this->hydrator, new Category());
            $categories = $resultSet->initialize($result);
        } return $categories;
    }

    public function getExpenses($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('e' => 'expenses'))
            ->join(array('p' => 'properties'), 'e.property_id = p.id', 
                array('property_id' => 'id', 'property_name' => 'name', '*'), 'left')
            ->join(array('c' => 'financial_categories'), 'e.category_id = c.id', 
                array('category_id' => 'id', 'category_name' => 'name', 'category_description' => 'description', 'category_note' => 'note', '*'), 'left')
            ->join(array('r' => 'rates'), 'e.rate_id = r.id', 
                array('rate_id' => 'id', 'rate_name' => 'name', '*'), 'left')
            ->join(array('e2' => 'expenses'), 'e.id = e2.id', '*', 'left');

        if($where) $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        //var_dump($sql->getSqlStringForSqlObject($select));

        $result = $stmt->execute();
        $expenses = array();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            foreach($result as $r){
                $expense = $this->hydrator->hydrate($r, new Expense());
                $expense->setProperty($this->hydrator->hydrate($r, new Property()));
                $expense->setCategory($this->hydrator->hydrate($r, new Category()));
                $expense->setRate($this->hydrator->hydrate($r, new Rate()));
                $expenses[] = $expense;
            } 
        } return $expenses;
    }

    public function getIncomes($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('i' => 'incomes'))
            ->join(array('p' => 'properties'), 'i.property_id = p.id', 
                array('property_id' => 'id', 'property_name' => 'name', '*'), 'left')
            ->join(array('c' => 'financial_categories'), 'i.category_id = c.id', 
                array('category_id' => 'id', 'category_name' => 'name', 'category_description' => 'description', 'category_note' => 'note', '*'), 'left')
            ->join(array('r' => 'rates'), 'i.rate_id = r.id', 
                array('rate_id' => 'id', 'rate_name' => 'name', '*'), 'left')
            ->join(array('i2' => 'incomes'), 'i.id = i2.id', '*', 'left');;

        if($where) $select->where($where);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        $incomes = array();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            foreach($result as $r){
                $income = $this->hydrator->hydrate($r, new Income());
                $income->setProperty($this->hydrator->hydrate($r, new Property()));
                $income->setCategory($this->hydrator->hydrate($r, new Category())); 
                $income->setRate($this->hydrator->hydrate($r, new Rate()));
                $incomes[] = $income;
            } 
        } return $incomes;
    }

    public function saveCategory(Category $entity){
        $data = $this->hydrator->extract($entity);
        unset($data['id']); unset($data['category_id']);

        if($entity->getId()){
            $action = new Update('financial_categories');
            $action->set($data);
            $action->where(array('id = ?' => $entity->getId()));
        } else{
            $action = new Insert('financial_categories');
            $action->values($data);   
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){ 
            return $entity;
        } throw new \Exception('Database error: save()');
    }

    public function saveExpense(Expense $entity){
        $data = $this->hydrator->extract($entity);
	//var_dump($data); die;
        unset($data['id']); unset($data['property']); 
        unset($data['category']); unset($data['rate']);
        unset($data['total']); unset($data['dates']);
        
        $data['property_id'] = $entity->getProperty()->getId();
        $data['category_id'] = $entity->getCategory()->getId();
        $data['rate_id'] = 5;//$entity->getRate()->getId();
        $data['date_from'] = $data['date_from'] ? $data['date_from'] : NULL;
        $data['date_to'] = $data['date_to'] ? $data['date_to'] : NULL;
        
        if($entity->getId()){
            $action = new Update('expenses');
            $action->set($data);
            $action->where(array('id = ?' => $entity->getId()));
        } else{
            $action = new Insert('expenses');
            $action->values($data);
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){ 
            return $entity;
        } throw new \Exception('Database error: save()');
    }

    public function saveIncome(Income $entity){
	   $data = $this->hydrator->extract($entity);
        
	   unset($data['id']); unset($data['property']); 
        unset($data['category']); unset($data['rate']);
        unset($data['total']); unset($data['dates']);
        
        $data['property_id'] = $entity->getProperty()->getId();
        $data['category_id'] = $entity->getCategory()->getId();
        $data['rate_id'] = 5;//$entity->getRate()->getId();
        $data['date_from'] = $data['date_from'] ? $data['date_from'] : NULL;
        $data['date_to'] = $data['date_to'] ? $data['date_to'] : NULL;
	//var_dump($data); die;

        if($entity->getId()){
            $action = new Update('incomes');
            $action->set($data);
            $action->where(array('id = ?' => $entity->getId()));
        } else{
            $action = new Insert('incomes');
            $action->values($data);
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){ 
            return $entity;
        } throw new \Exception('Database error: save()');
    }

    public function deleteExpense(Expense $entity){
        if($entity->getId()){
            $action = new Delete('expenses');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }

    public function deleteIncome(Income $entity){
        if($entity->getId()){
            $action = new Delete('incomes');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }

    public function deleteCategory(Category $entity){
        if($entity->getId()){
            $action = new Delete('financial_categories');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }
}