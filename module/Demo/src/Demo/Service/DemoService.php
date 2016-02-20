<?php namespace Demo\Service;

use Demo\Entity\Person;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Stdlib\Hydrator\ClassMethods;

class DemoService{
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

    public function find($id){
        $persons = $this->findAll();
        return $persons->current();
    }

    public function findAll($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('t' => 'persons'));

        if($where) $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            $entity = new Person();
            $resultSet = new HydratingResultSet($this->hydrator, $entity);
            return $resultSet->initialize($result);
        } return array();
    }

    public function save(Person $entity){
        $data = $this->hydrator->extract($entity);
        unset($data['id']);

        if($entity->getId()){
            $action = new Update('persons');
            $action->set($data);
            $action->where(array('id = ?' => $entity->getId()));
        } else{
            $action = new Insert('persons');
            $action->values($data);   
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){ 
            if(!$entity->getId()){
                $id = $result->getGeneratedValue();
                $entity->setId($id);
            } return $entity;
        } throw new \Exception('Database error: save()');
    }

    public function delete(Person $entity){
        if($entity->getId()){
            $action = new Delete('persons');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }
}