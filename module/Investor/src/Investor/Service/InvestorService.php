<?php namespace Investor\Service;

use Investor\Entity\Category;
use Investor\Entity\Allocation;
use SiteUser\Entity\User;
use Property\Entity\Property;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Stdlib\Hydrator\ClassMethods;

class InvestorService{
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    public function __construct(AdapterInterface $dbAdapter){
        $this->dbAdapter = $dbAdapter;
        $this->hydrator  = new ClassMethods(FALSE);
    }

    public function findInvestment($id){
        $investments = $this->findAllAllocations('a.user_id = '.$id);
        //var_dump($investments); die;
        return $investments;
    }

    public function findAllocation($id){
        $allocations = $this->findAllAllocations('a.id = '.$id);
        return array_shift($allocations);
    }

    public function findCategory($id){
        $categories = $this->findAllCategories('c.id = '.$id);
        return $categories->current();
    }

    public function findAllAllocations($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('a' => 'investor_allocations'))
            ->columns(array('allocation_id' => 'id', 'allocation_note' => 'note', '*'))
            ->join(array('u' => 'user'), 'a.user_id = u.id', '*', 'left')
            ->join(array('ac' => 'allocation_categories'), 'a.category_id = ac.id', 
                array('category_note' => 'note', 'category_name' => 'name', '*'), 'left')
            ->join(array('p' => 'properties'), 'a.property_id = p.id', 
                array('property_name' => 'name', '*'), 'left');

        if($where) $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            $allocations = array();
            
            // hydrate
            while($data = $result->current()){
                $allocation = $this->hydrator->hydrate($data, new Allocation()); 
                $allocation->setInvestor($this->hydrator->hydrate($data, new User()));
                $allocation->setCategory($this->hydrator->hydrate($data, new Category()));
                $allocation->setProperty($this->hydrator->hydrate($data, new Property()));
                $allocations[] = $allocation;
                $result->next();   
            } return $allocations;
        } return array();
    }

    public function findAllCategories($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('c' => 'allocation_categories'));

        if($where) $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $categories = array();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            $resultSet = new HydratingResultSet($this->hydrator, new Category());
            $categories = $resultSet->initialize($result);
        } return $categories;
    }

    public function saveAllocation(Allocation $allocation){
        $data = $this->hydrator->extract($allocation);
        unset($data['id']);
        
        unset($data['investor']);
        $data['user_id'] = $allocation->getInvestor()->getId();

        unset($data['category']);
        $data['category_id'] = $allocation->getCategory()->getId();

        unset($data['property']);
        $data['property_id'] = $allocation->getProperty()->getId();
        if($allocation->getId()){
            $action = new Update('investor_allocations');
            $action->set($data);
            $action->where(array('id = ?' => $allocation->getId()));
        } else{
            $action = new Insert('investor_allocations');
            $action->values($data);   
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){ 
            return $allocation;
        } throw new \Exception('Database error: saveAllocation()');
    }

    public function saveCategory(Category $category){
        $data = $this->hydrator->extract($category);
        unset($data['id']);

        if($category->getId()){
            $action = new Update('allocation_categories');
            $action->set($data);
            $action->where(array('id = ?' => $category->getId()));
        } else{
            $action = new Insert('allocation_categories');
            $action->values($data);   
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){ 
            if(!$category->getId()){
                $id = $result->getGeneratedValue();
                $category->setCategory_id($id);
            } return $category;
        } throw new \Exception('Database error: saveCategory()');
    }

    public function deleteAllocation($entity){
        if($entity->getId()){
            $action = new Delete('investor_allocations');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }

    public function deleteCategory($entity){
        if($entity->getId()){
            $action = new Delete('allocation_categories');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }
}