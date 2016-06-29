<?php namespace Application\Service;

use Application\Hydrator\StandardHydrator;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class ServiceAbstract{
    
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;
    
	/**
     * @var \Zend\Authentication\AuthenticationService
     */
	protected $auth;

	/**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    /**
     * @var bool
     */
    protected $inTransaction;

	public function __construct(ServiceLocatorInterface $sl){
        $this->serviceLocator = $sl;
        $this->hydrator  = new StandardHydrator();
    }

    /**
     * @param string $model Module/Model 
     * @return mixed
     */
    public function getModel($model) {
        $model .= 'Model';
        $sl = $this->getServiceLocator();
        if ($sl->has($model)) {
            return $sl->get($model);
        } return false;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator(){
        return $this->serviceLocator;    
    }

    protected function getAuth(){
        if (is_null($this->auth)) {
            $this->auth = $this->getServiceLocator()->get('zfcuser_auth_service');
        }
        return $this->auth;
    }
    
    protected function getDb(){
        if (is_null($this->dbAdapter)) {
            $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        }
        return $this->dbAdapter;
    }

    protected function getUserId(){
        if($this->getAuth()->hasIdentity())
            return $this->getAuth()->getIdentity()->getId();
    }

    private function execute($action){
    	$sql 	= new Sql($this->getDb());
    	$stmt   = $sql->prepareStatementForSqlObject($action);
        try {
            $result = $stmt->execute();
        }
        catch (\Exception $e) {
            if ($this->getDb()->getDriver()->getConnection()->inTransaction()) {
                $this->rollBackTransaction();
            }
            throw new \Exception($e->getMessage().' : '.$sql->buildSqlString($action));
        }
        return $result;
    }

    protected function startTransaction() {
        $this->inTransaction = true;
        $this->getDb()->getDriver()->getConnection()->beginTransaction();
    }

    protected function commitTransaction() {
        $this->inTransaction = true;
        $this->getDb()->getDriver()->getConnection()->commit();
    }

    protected function rollBackTransaction() {
        $this->getDb()->getDriver()->getConnection()->rollback();
    }

    protected function _insert($table, $data){
    	$action = new Insert($table);
        unset($data['id']);
    	$action->values($data);
        //die(var_dump($this->execute($action), 'insert'));
    	return $this->execute($action)->getGeneratedValue();
    }

    protected function _select($table, $columns = null, $where = null){
        $action = new Select($table);
        $action->columns($columns ? $columns : array('*'), false);
        if ($where) {
            $action->where($where);
        }
        $result = $this->execute($action);
        if ($result->isQueryResult()) {
            if ($result->count() > 1) {
                $data = array();
                foreach ($result as $row) {
                    $data[] = $row;
                }
            }
            else {
                $data = $result->current();
            }
            return $data;
        }
        return null;
    }

    protected function _update($table, $data, $where){
    	$action = new Update($table);
        unset($data['id']);
        $action->set($data);
        $action->where($where);
        //die(var_dump($this->execute($action)->getAffectedRows(), 'update'));
        return $this->execute($action)->getAffectedRows();
    }

    protected function _delete($table, $where){
    	$action = new Delete($table);
        $action->where($where);
        //die(var_dump($this->execute($action)->getAffectedRows(), 'delete'));
        return $this->execute($action)->getAffectedRows();
    }
}