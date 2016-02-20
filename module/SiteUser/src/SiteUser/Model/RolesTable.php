<?php namespace SiteUser\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class RolesTable extends AbstractTableGateway{
    protected $table = 'roles';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Role());
        $this->initialize();
    }

    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getRole($id){
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if(!$row)
            throw new \Exception("Could not find row $id");
        return $row;
    }

    public function getOptions(){
        $roles = $this->fetchAll();
        $options = array();
        foreach($roles as $r){
            //var_dump($r); die;
            $options[$r->id] = $r->name;
        } return $options;
    }

    public function saveRole(Role $role){
        $data = array(
            'name'          => $role->name,
        );

        $id = (int) $role->getId();
        if($id == 0)
            $this->insert($data);
        else{
            if($this->getRole($id))
                $this->update($data, array('id' => $id));
            else
                throw new \Exception('Role id does not exist!');
        }
    }

    public function deleteRole($id){
        $this->delete(array('id' => (int) $id));
    }
}