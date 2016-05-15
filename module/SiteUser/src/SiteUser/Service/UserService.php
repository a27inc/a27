<?php namespace SiteUser\Service;

use SiteUser\Entity\User;
use SiteUser\Entity\Role;
use SiteUser\Entity\RoleChild;
use SiteUser\Entity\UserRole;
use SiteUser\Entity\Permission;
use SiteUser\Entity\RolePermission;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Stdlib\Hydrator\ClassMethods;

class UserService{
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    /**
     * @param PropertyMapper $propertyMapper
     */
    public function __construct(AdapterInterface $dbAdapter){
        $this->dbAdapter = $dbAdapter;
        $this->hydrator  = new ClassMethods(FALSE);
    }

    public function findUser($id){
        $users = $this->findAllUsers('u.id = '.$id);
        return array_shift($users);
    }

    public function findRole($id){
        $roles = $this->findAllRoles('r.id = '.$id);
        return array_shift($roles);
    }

    public function findPermission($id){
        $permissions = $this->findAllPermissions('p.id = '.$id);
        return $permissions->current();
    }

    public function findAllUsers($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('u' => 'user'))
            ->columns(array('uid' => 'id', '*'))
            ->join(array('ur' => 'user_role'), 'u.id = ur.user_id', '*', 'left')
            ->join(array('r' => 'roles'), 'ur.role_id = r.id', array('role_id' => 'id', 'role_name'), 'left');

        if($where) $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            $users = array();
            $roles = array();
            
            // hydrate
            while($data = $result->current()){
                $data['user_id'] = $data['uid'];
                if(!isset($users[$data['user_id']])){
                    $users[$data['user_id']] = $this->hydrator->hydrate($data, new User()); 
                    $roles[$data['user_id']] = new UserRole($data['user_id']);
                } $roles[$data['user_id']]->addRole($this->getRole($data));
                $result->next();   
            } 

            // set user roles
            foreach($users as $uid => $user) 
                $users[$uid]->setRole($roles[$uid]);
                
            return $users;
        } return array();
    }

    public function findAllRoles($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('r' => 'roles'))
            ->columns(array('rid' => 'id', '*'))
            ->join(array('rp' => 'role_permission'), 'r.id = rp.role_id', '*', 'left')
            ->join(array('hr' => 'role_role'), 'r.id = hr.parent_id', '*', 'left')
            ->join(array('rc' => 'roles'), 'hr.child_id = rc.id', array('child_name' => 'role_name'), 'left')
            ->join(array('p' => 'permissions'), 'rp.permission_id = p.id', 
                array('permission_id' => 'id', 'permission_name'), 'left');

        if($where) 
            $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            $roles = array();
            $permissions = array();
            
            // hydrate
            while($data = $result->current()){
                
                $data['role_id'] = $data['rid'];

                if(!isset($roles[$data['role_id']])){
                    $roles[$data['role_id']] = $this->hydrator->hydrate($data, new Role()); 
                    
                    if($data['child_id'])
                        $roles[$data['role_id']]->setChild($this->hydrator->hydrate($data, new RoleChild()));
                    
                    $permissions[$data['role_id']] = new RolePermission($data['role_id']);
                } 

                $permissions[$data['role_id']]->addPermission($this->getPermission($data));
                
                $result->next();   
            }

            // set user roles
            foreach($roles as $rid => $role) 
                $roles[$rid]->setPermission($permissions[$rid]);
   
            return $roles;
        } return array();
    }

    public function findAllPermissions($where = NULL){
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(array('p' => 'permissions'))
            ->columns(array('permission_id' => 'id', 'permission_name'));

        if($where) 
            $select->where($where);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $permissions = array();
        if($result instanceof ResultInterface && $result->isQueryResult()){
            $resultSet = new HydratingResultSet($this->hydrator, new Permission());
            $permissions = $resultSet->initialize($result);
        } return $permissions;
    }

    private function getRole($data){
        $role = new Role();
        return $this->hydrator->hydrate($data, $role);
    }

    private function getPermission($data){
        $permission = new Permission();
        return $this->hydrator->hydrate($data, $permission);
    }

    public function saveUser(User $user){
        $data = $this->hydrator->extract($user);
        unset($data['id']);

        // Get role
        $role = $data['role'];
        unset($data['role']);

        if($user->getId()){
            $action = new Update('user');
            $action->set($data);
            $action->where(array('id = ?' => $user->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){ 
            if($user->getId() && $role)   
                $this->saveUserRole($role);

            return $user;
        } throw new \Exception('Database error: save()');
    }

    public function saveRole(Role $role){
        $data = $this->hydrator->extract($role);
        unset($data['id']);

        // Get permission
        $permission = $data['permission'];
        unset($data['permission']);

        // Get child
        $child = $data['child'];
        unset($data['child']);

        if($role->getId()){
            $action = new Update('roles');
            $action->set(array('role_name' => $data['role_name']));
            $action->where(array('id = ?' => $role->getId()));
        } else{
            $action = new Insert('roles');
            $action->values(array('role_name' => $data['role_name']));   
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);

        $result = $stmt->execute();

        if($result instanceof ResultInterface){ 
            if(!$role->getId()){
                $id = $result->getGeneratedValue();
                $role->setRole_id($id);
                if($permission) $permission->setRole_id($id);
            } $child->setParent_id($role->getId());

            if($role->getId() && $permission){   
                $this->saveRolePermission($permission);
            } $this->saveRoleChild($child);

            return $role;
        } throw new \Exception('Database error: saveRole()');
    }

    public function saveRoleChild(RoleChild $role){
        if($role->getName()){
            $action = new Update('role_role');
            $action->set(array('child_id' => (int) $role->getId()));
            $action->where(array('parent_id = ?' => (int) $role->getParent_id()));
        } else{
            $action = new Insert('role_role');
            $action->values(array(
                'parent_id' => (int) $role->getParent_id(),
                'child_id' => (int) $role->getId()));   
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if(!$result instanceof ResultInterface) 
            throw new \Exception('Database error: saveRoleChild()');
    }

    public function savePermission(Permission $permission){
        $data = $this->hydrator->extract($permission);

        if($permission->getId()){
            $action = new Update('permissions');
            $action->set(array('permission_name' => $data['permission_name']));
            $action->where(array('id = ?' => $permission->getId()));
        } else{
            $action = new Insert('permissions');
            $action->values(array('permission_name' => $data['permission_name']));   
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){ 
            if(!$permission->getId()){
                $id = $result->getGeneratedValue();
                $permission->setPermission_id($id);
            } return $permission;
        } throw new \Exception('Database error: savePermission()');
    }
    
    public function addUserRole($userId, $roleId) {
        $action = new Insert('user_role');
        $action->values(array('user_id' => $userId, 'role_id' => $roleId));

        //Execute
        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if(!$result instanceof ResultInterface)
            throw new \Exception('Database error: user_role insert');
    }
    
    public function saveUserRole(UserRole $role){       
        $old = $exist = array();
        foreach($role->getRoles() as $r){
            if(!in_array($r->getId(), $role->getIds()))
                $old[] = $r->getId();
            $exist[] = $r->getId();
        } $new = array_diff($role->getIds(), $exist);

        if($new){
            foreach($new as $rid){
                if($oid = array_shift($old)){ //Update
                    $action = new Update('user_role');
                    $action->set(array('role_id' => $rid));
                    $action->where(array('user_id = ? AND role_id = ?' => array($role->getUser_id(), $oid)));    
                } else{ //Insert
                    $action = new Insert('user_role');
                    $action->values(array('user_id' => $role->getUser_id(), 'role_id' => $rid));  
                }

                //Execute
                $sql    = new Sql($this->dbAdapter);
                $stmt   = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
                if(!$result instanceof ResultInterface) 
                    throw new \Exception('Database error: user_role insert/update');
            } 
        }

        if($old){ //Delete
            $action = new Delete('user_role');
            $action->where(array('user_id = ? AND role_id IN('.implode(',', $old).')' => array($role->getUser_id()))); 
            $sql    = new Sql($this->dbAdapter);
            $stmt   = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute(); 
            if(!$result instanceof ResultInterface) 
                throw new \Exception('Database error: removing old user roles');
        }  
    }

    public function saveRolePermission(RolePermission $permission){       
        $old = $exist = array();
        foreach($permission->getPermissions() as $p){
            if(!in_array($p->getId(), $permission->getIds()))
                $old[] = $p->getId();
            $exist[] = $p->getId();
        } $new = array_diff($permission->getIds(), $exist);

        if(!$exist && $permission->getIds())
            $new = $permission->getIds();

        if($new){
            foreach($new as $rid){
                if($oid = array_shift($old)){ //Update
                    $action = new Update('role_permission');
                    $action->set(array('permission_id' => $rid));
                    $action->where(array('role_id = ? AND permission_id = ?' => array($permission->getRole_id(), $oid)));    
                } else{ //Insert
                    $action = new Insert('role_permission');
                    $action->values(array('role_id' => $permission->getRole_id(), 'permission_id' => $rid));  
                }

                //Execute
                $sql    = new Sql($this->dbAdapter);
                $stmt   = $sql->prepareStatementForSqlObject($action);
                $result = $stmt->execute();
                if(!$result instanceof ResultInterface) 
                    throw new \Exception('Database error: role_permission insert/update');
            } 
        }

        if($old){ //Delete
            $action = new Delete('role_permission');
            $action->where(array('role_id = ? AND permission_id IN('.implode(',', $old).')' => array($permission->getRole_id()))); 
            $sql    = new Sql($this->dbAdapter);
            $stmt   = $sql->prepareStatementForSqlObject($action);
            $result = $stmt->execute(); 

            if(!$result instanceof ResultInterface) 
                throw new \Exception('Database error: removing old role permissions');
        }  
    }

    public function deleteUser(User $entity){
        if($entity->getId()){
            $action = new Delete('user');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }

    public function deleteRole($entity){
        if($entity->getId()){
            $action = new Delete('roles');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }

    public function deletePermission($entity){
        if($entity->getId()){
            $action = new Delete('permissions');
            $action->where(array('id = ?' => $entity->getId()));
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }
}