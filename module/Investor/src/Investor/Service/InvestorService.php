<?php namespace Investor\Service;

use Application\Service\ServiceAbstract;

use Investor\Entity\Allocation;
use Investor\Entity\Category;
use Investor\Entity\Investor;
use Investor\Hydrator\AllocationHydrator;
use Investor\Hydrator\CategoryHydrator;
use Property\Entity\Property;
use SiteUser\Entity\User;

class InvestorService extends ServiceAbstract{

    public function findAllocation($id){
        $model = $this->getModel('Investor/Allocation');
        return $model->open($id);
    }

    public function findCategory($id){
        $model = $this->getModel('Investor/Category');
        return $model->open($id);
    }

    public function findInvestor($id){
        $model = $this->getModel('Investor/Investor');
        return $model->open($id);
    }

    public function findInvestment($id){
        $investments = $this->findAllAllocations(array('t.user_id = ?' => $id));
        //var_dump($investments); die;
        return $investments;
    }

    public function findAllAllocations($where = NULL){
        $model = $this->getModel('Investor/Allocation');
        //die(var_dump($model->listQuery($where)));
        return $model->listQuery($where);
    }

    public function findAllCategories($where = NULL){
        $model = $this->getModel('Investor/Category');
        return $model->listQuery($where);
    }

    public function findAllInvestors($where = NULL){
        $model = $this->getModel('Investor/Investor');
        return $model->listQuery($where);
    }

    public function saveAllocation(Allocation $entity){
        $hydrator = new AllocationHydrator();
        $data = $hydrator->extract($entity);
        //die(var_dump($data));
        if($entity->getId()){
            $this->_update('investor_allocations', $data, array('id = ?' => $entity->getId()));
        } elseif($id = $this->_insert('investor_allocations', $data)){
            $entity->setId($id);
        } return $entity;
    }

    public function saveCategory(Category $entity){
        $hydrator = new CategoryHydrator();
        $data = $hydrator->extract($entity);

        if($entity->getId()){
            $this->_update('allocation_categories', $data, array('id = ?' => $entity->getId()));
        } elseif($id = $this->_insert('allocation_categories', $data)){
            $entity->setId($id);
        } return $entity;
    }

    public function saveInvestor(Investor $entity){
        $hydrator = new AllocationHydrator();
        $data = $hydrator->extract($entity);

        if($entity->getId()){
            $this->_update('investors', $data, array('id = ?' => $entity->getId()));
        } elseif($id = $this->_insert('investors', $data)){
            $entity->setId($id);
        } return $entity;
    }

    public function deleteAllocation($entity){
        if($entity->getId()){
            return $this->_delete('investor_allocations', array('id = ?' => $entity->getId()));
        } return false; 
    }

    public function deleteCategory($entity){
        if($entity->getId()){
            return $this->_delete('allocation_categories', array('id = ?' => $entity->getId()));
        } return false; 
    }
}