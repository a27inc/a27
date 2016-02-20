<?php namespace Landlord\Service;

use Landlord\Entity\Tenant;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Stdlib\Hydrator\ClassMethods;

class LandlordService{
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
        $tenants = $this->findAll();
        return $tenants->current();
    }

    public function findAll($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('t' => 'tenants'));

        if($where) $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            $entity = new Tenant();
            $resultSet = new HydratingResultSet($this->hydrator, $entity);
            return $resultSet->initialize($result);
        } return array();
    }

    public function save(Tenant $entity){
        $data = $this->hydrator->extract($entity);
        unset($data['id']);

        if($entity->getId()){
            $action = new Update('tenants');
            $action->set($data);
            $action->where(array('id = ?' => $entity->getId()));
        } else{
            $action = new Insert('tenants');
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

    public function delete(Tenant $entity){
        if($entity->getId()){
            $action = new Delete('tenants');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }
}