<?php namespace Financial\Service;

use Application\Service\ServiceAbstract;

use Financial\Entity\Income;
use Financial\Entity\Expense;
use Financial\Entity\FinancialSummary;
use Financial\Entity\Category;

use Financial\Hydrator\CategoryHydrator;
use Financial\Hydrator\ExpenseHydrator;
use Financial\Hydrator\IncomeHydrator;

class FinancialService extends ServiceAbstract{

    public function getCategory($id){
        $model = $this->getModel('Financial/Category');
        return $model->open($id);
    }

    public function getExpense($id){
        $model = $this->getModel('Financial/Expense');
        return $model->open($id);
    }

    public function getIncome($id){
        $model = $this->getModel('Financial/Income');
        //die(var_dump($model->open($id)));
        return $model->open($id);
    }

    public function getFinancialSummary($year = null, $property = null){
        $summary = new FinancialSummary();

        $where = '';
        if($year) $where .= 't.date_filed LIKE "'.$year.'%"';
        if($property) $where .= ' t.property_id = '.$property;
        $where = $where ? trim($where) : null;
        $incomes = $this->getIncomes($where);
        //var_dump($incomes); die;
        foreach($incomes as $i)
            $summary->addIncome($i);

        $where = '';
        if($year) $where .= 't.date_filed LIKE "'.$year.'%"';
        if($property) $where .= ' t.property_id = '.$property;
        $where = $where ? trim($where) : null;
        $expenses = $this->getExpenses($where);
        //var_dump($expenses); die;
        foreach($expenses as $e)
            $summary->addExpense($e);

        return $summary;
    }

    public function getCategories($where = null){
        $model = $this->getModel('Financial/Category');
        return $model->openList($where);
    }

    public function getExpenses($where = null){
        $model = $this->getModel('Financial/Expense');
        $model->orderDesc('dateFiled');
        return $model->openList($where);
    }

    public function getIncomes($where = null){
        $model = $this->getModel('Financial/Income');
        $model->orderDesc('dateFiled');
        return $model->openList($where);
    }

    public function saveCategory(Category $entity){
        $hydrator = new CategoryHydrator();
        $data = $hydrator->extract($entity);

        if($entity->getId()){
            $this->_update('financial_categories', $data, array('id = ?' => $entity->getId()));
        } elseif($id = $this->_insert('financial_categories', $data)){
                $entity->setId($id);
        } return $entity;
    }

    public function saveExpense(Expense $entity){
        $hydrator = new ExpenseHydrator();
        $data = $hydrator->extract($entity);

        if($entity->getId()){
            $this->_update('expenses', $data, array('id = ?' => $entity->getId()));
        } else {
            $data['author_id'] = $this->getUserId();
            if($id = $this->_insert('expenses', $data)){
                $entity->setId($id);
                $entity->setAuthorId($data['author_id']);
            }
        } return $entity;
    }

    public function saveIncome(Income $entity){
        $hydrator = new IncomeHydrator();
        $data = $hydrator->extract($entity);
        //die(var_dump($data));
        if($entity->getId()){
            $this->_update('incomes', $data, array('id = ?' => $entity->getId()));
        } else {
            $data['author_id'] = $this->getUserId();
            if($id = $this->_insert('incomes', $data)) {
                $entity->setId($id);
                $entity->setAuthorId($data['author_id']);
            }
        } return $entity;
    }

    public function deleteExpense(Expense $entity){
        if($entity->getId()){
            return $this->_delete('expenses', array('id = ?' => $entity->getId()));
        } return false; 
    }

    public function deleteIncome(Income $entity){
        if($entity->getId()){
            return $this->_delete('incomes', array('id = ?' => $entity->getId()));
        } return false; 
    }

    public function deleteCategory(Category $entity){
        if($entity->getId()){
            return $this->_delete('financial_categories', array('id = ?' => $entity->getId()));
        } return false;   
    }
}