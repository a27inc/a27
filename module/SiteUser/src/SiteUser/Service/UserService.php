<?php namespace SiteUser\Service;

use Application\Service\ServiceAbstract;

use SiteUser\Entity\User;
use SiteUser\Entity\Role;
use SiteUser\Entity\Permission;
use SiteUser\Hydrator\PermissionHydrator;
use SiteUser\Hydrator\RoleHydrator;
use SiteUser\Hydrator\UserHydrator;

class UserService extends ServiceAbstract{

    public function findUser($id){
        $model = $this->getModel('SiteUser/User');
        // set limit because joining roles can return multiple rows
        //die(var_dump($model->open('id', $id, 100)));
        return $model->open('id', $id, 100);
    }

    public function findRole($id){
        $model = $this->getModel('SiteUser/Role');
        //die(var_dump($model->open('id', $id, 100)));
        return $model->open('id', $id, 100);
    }

    public function findPermission($id){
        $model = $this->getModel('SiteUser/Permission');
        //die(var_dump($model->open('id', $id)));
        return $model->open('id', $id);
    }

    public function findAllUsers($where = null){
        $model = $this->getModel('SiteUser/User');
        return $model->listQuery($where);
    }

    public function findAllRoles($where = null){
        $model = $this->getModel('SiteUser/Role');
        return $model->listQuery($where);
    }

    public function findAllPermissions($where = null){
        $model = $this->getModel('SiteUser/Permission');
        return $model->listQuery($where);
    }

    public function saveUser(User $entity){
        $hydrator = new UserHydrator();
        $data = $hydrator->extract($entity);

        $this->startTransaction();

        if($entity->getId()){
            $this->_update('user', $data, array('id = ?' => $entity->getId()));
        }

        $this->saveUserRole($entity);

        $this->commitTransaction();
        
        return $entity;
    }

    private function saveUserRole(User $entity){
        $old = array_diff(array_keys($entity->getRoles()), $entity->getRoleIds());
        $new = array_diff($entity->getRoleIds(), array_keys($entity->getRoles()));
        if ($old || $new) {
            foreach ($new as $roleId) {
                if ($whereId = array_shift($old)) {
                    $this->_update('user_role', array('role_id' => $roleId),
                        array('user_id = ? AND role_id = ?' => array($entity->getId(), $whereId)));
                }
                else {
                    $this->_insert('user_role', array(
                        'user_id' => $entity->getId(),
                        'role_id' => $roleId));
                }
            }
            if ($old) {
                $this->_delete('user_role', array(
                    'user_id = ? AND role_id IN(?)' => array($entity->getId(), implode(',',$old))));
            }
        }
    }

    public function saveRole(Role $entity){
        $hydrator = new RoleHydrator();
        $data = $hydrator->extract($entity);

        $this->startTransaction();

        if($entity->getId()){
            $this->_update('roles', $data, array('id = ?' => $entity->getId()));
        }
        else {
            $this->_insert('roles', $data);
        }

        $this->saveRoleChild($entity);

        $this->saveRolePermission($entity);

        $this->commitTransaction();

        return $entity;
    }

    private function saveRoleChild(Role $entity){
        if($entity->getParentId() && $entity->getChildId()) {
            $this->_update('role_role', array('child_id' => $entity->getChildId()), array('parent_id = ?' => $entity->getParentId()));
        }
        else if ($entity->getChildId()) {
            $this->_insert('role_role', array('child_id' => $entity->getChildId(), 'parent_id' => $entity->getParentId()));
        }
    }

    private function saveRolePermission(Role $entity){
        $old = array_diff(array_keys($entity->getPermissions()), $entity->getPermissionIds());
        $new = array_diff($entity->getPermissionIds(), array_keys($entity->getPermissions()));
        if ($old || $new) {
            foreach ($new as $permissionId) {
                if ($whereId = array_shift($old)) {
                    $this->_update('role_permission', array('permission_id' => $permissionId),
                        array('role_id = ? AND permission_id = ?' => array($entity->getId(), $whereId)));
                }
                else {
                    $this->_insert('role_permission', array(
                        'role_id' => $entity->getId(),
                        'permission_id' => $permissionId));
                }
            }
            if ($old) {
                $this->_delete('role_permission', array(
                    'role_id = ? AND permission_id IN(?)' => array($entity->getId(), implode(',',$old))));
            }
        }
    }

    public function savePermission(Permission $entity){
        $hydrator = new PermissionHydrator();
        $data = $hydrator->extract($entity);

        if($entity->getId()){
            $this->_update('permissions', $data, array('id = ?' => $entity->getId()));
        }
        else {
            $this->_insert('permissions', $data);
        }
        
        return $entity;
    }

    public function deleteUser(User $entity){
        if($entity->getId()){
            return $this->_delete('user', array('id = ?' => $entity->getId()));
        } return false; 
    }

    public function deleteRole(Role $entity){
        if($entity->getId()){
            return $this->_delete('roles', array('id = ?' => $entity->getId()));
        } return false; 
    }

    public function deletePermission(Permission $entity){
        if($entity->getId()){
            return $this->_delete('permissions', array('id = ?' => $entity->getId()));
        } return false; 
    }
}