<?php namespace Landlord\Service;

use Application\Service\ServiceAbstract;
use Landlord\Entity\Tenant;
use Landlord\Hydrator\TenantHydrator;

class LandlordService extends ServiceAbstract{

    public function find($id){
        $model = $this->getModel('Landlord/Tenant');
        //die(var_dump($model->open('id', $id)));
        return $model->open('id', $id);
    }

    public function findAll($where = NULL){
        $model = $this->getModel('Landlord/Tenant');
        //die(var_dump($model->listQuery($where)));
        return $model->listQuery($where);
    }

    public function saveTenant(Tenant $entity){
        $hydrator = new TenantHydrator();
        $data = $hydrator->extract($entity);
        //var_dump($data); die;
        if($entity->getId()){
            $this->_update('tenants', $data, array('id = ?' => $entity->getId()));
        } else {
            $data['author_id'] = $this->getUserId();
            if($id = $this->_insert('tenants', $data)){
                $entity->setId($id);
                $entity->setAuthorId($data['author_id']);
            }
        } return $entity;
    }

    public function deleteTenant(Tenant $entity){
        if($entity->getId()){
            return $this->_delete('tenants', array('id = ?' => $entity->getId()));
        } return false;
    }
}