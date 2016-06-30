<?php namespace SiteUser\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class PermissionsTable extends AbstractTableGateway{
    protected $table = 'permissions';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Permission());
        $this->initialize();
    }

    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getPermission($id){
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if(!$row)
            throw new \Exception("Could not find row $id");
        return $row;
    }

    public function getOptions(){
        $permissions = $this->fetchAll();
        $options = array();
        foreach($permissions as $p){
            $options[$p->id] = $p->name;
        } return $options;
    }

    public function savePermission(Permission $permission){
        $data = array(
            'name'          => $permission->name,
        );

        $id = (int) $permission->getId();
        if($id == 0)
            $this->_insert($data);
        else{
            if($this->getPermission($id))
                $this->_update($data, array('id' => $id));
            else
                throw new \Exception('Permission id does not exist!');
        }
    }

    public function deletePermission($id){
        $this->_delete(array('id' => (int) $id));
    }
}