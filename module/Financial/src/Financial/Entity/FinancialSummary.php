<?php namespace Financial\Entity;

use Property\Entity\Property;

class FinancialSummary{

    /**
     * @var array
     */
    public $ytd;

    /**
     * @var array
     */
    public $ytd_property_profit;

    /**
     * @var int
     */
    public $ytd_assessment;

    /**
     * @var int
     */
    public $assessment_total = 0;

    /**
     * @var array
     */
    public $total;

    /**
     * @var array
     */
    public $ytd_total;

    /**
     * @var array
     */
    public $category_total;

    /**
     * @var array
     */
    public $property_category_total;

    /**
     * @var array
     */
    public $property_total;

    /**
     * @var array
     */
    public $property_profit_total;

    /**
     * @var Expense
     */
    public $expense;  
    
    /**
     * @var Income
     */
    public $income;

    /**
     * @var Income
     */
    public $property;

    /**
     * @var int
     */
    public $property_count = 0;

    /**
     * @var int
     */
    public $head_quarter_id = 3;

    /**
     * @var int
     */
    public $disabled_status = 3;

    /**
     * @var array Y-m-d
     */
    public $property_start;

    /**
     * @param Expense | Income $expense_income
     */
    private function setYtd($obj){
        // to do excluded categories
        $yr = substr($obj->getDate_filed(), 0, 4);
        if(!isset($this->ytd[$yr]))
            $this->ytd[$yr] = 0;
        if(!isset($this->ytd_total[$yr]))
            $this->ytd_total[$yr] = 0;
        if(!isset($this->ytd_assessment[$yr]))
            $this->ytd_assessment[$yr] = 0;
        
        $pid = $obj->getProperty()->getId();
        if(!isset($this->ytd_property_profit[$pid][$yr]))
            $this->ytd_property_profit[$pid][$yr] = 0;
        if(!isset($this->property_profit_total[$pid]))
            $this->property_profit_total[$pid] = 0;
        if(!isset($this->property_total[$pid]))
            $this->property_total[$pid] = 0;
        
        $total = $obj->getTotal();
        if(!isset($this->total))
            $this->total = 0;

        if($obj instanceof Expense)
            $total = -$total;

        $cat = $obj->getCategory();
        $ecf = $cat->getExcl_cash_flow();
        $ea = $cat->getExcl_all();
        if(!$ecf && !$ea){
            if(!isset($this->property_start[$pid]) || $this->property_start[$pid] > $obj->getDate_filed()){
                $this->property_start[$pid] = $obj->getDate_filed();
                if(!isset($this->property_start[$this->head_quarter_id]) || $this->property_start[$this->head_quarter_id] > $obj->getDate_filed())    
                    $this->property_start[$this->head_quarter_id] = $obj->getDate_filed();
            }
            $this->ytd[$yr] += $total;
            if($obj instanceof Income || $pid != $this->head_quarter_id){
                $this->ytd_property_profit[$pid][$yr] += $total;
                $this->property_profit_total[$pid] += $total;
            } else{ // Headquarter expenses get passed into assesment   
                $this->ytd_assessment[$yr] += $total;
                $this->assessment_total += $total;  
            } 
        } 
        
        if(!$ea){
            $this->ytd_total[$yr] += $total;
            //if($obj instanceof Income || $pid != $this->head_quarter_id)   
            $this->property_total[$pid] += $total;
            $this->total += $total;   
        }

        if(!isset($this->property_category_total[$pid][$cat->getDisplay_name()]))
            $this->property_category_total[$pid][$cat->getDisplay_name()] = 0;
        $this->property_category_total[$pid][$cat->getDisplay_name()] += $total;

        if(!isset($this->category_total[$cat->getDisplay_name()]))
            $this->category_total[$cat->getDisplay_name()] = 0;
        $this->category_total[$cat->getDisplay_name()] += $total;   
    }

    /**
     * @param int       property_id
     * @param string    year
     * @return string
     */
    public function getYtd_property_profit($property, $year = NULL){
        if(!$year) $year = date('Y');
        return isset($this->ytd_property_profit[$property][$year])
            ? $this->ytd_property_profit[$property][$year]
            : 0;
    }

    /**
     * @return int
     */
    public function getProperty_assessment_total(){
        return $this->property_count
                ? $this->assessment_total / $this->property_count
                : $this->assessment_total;
    }

    /**
     * @return int
     */
    public function getAssessment_total(){
        return $this->assessment_total;
    }

    /**
     * @param string    year
     * @return int
     */
    public function getYtd_assessment($year = NULL){
        if(!$year) $year = date('Y');
        if(!empty($this->ytd_assessment[$year])){
            return $this->property_count
                ? $this->ytd_assessment[$year] / $this->property_count
                : $this->ytd_assessment[$year];
        } return 0;
    }

    /**
     * @return int
     */
    public function getTotal(){
        return $this->total;
    }

    /**
     * @param int       property_id
     * @param string    year
     * @return string
     */
    public function getProperty_profit_total($property){
        $ass = $property == $this->head_quarter_id
            ? 0 : $this->getProperty_assessment_total();
        if($this->property[$property]->getStatus_id() == $this->disabled_status)
            $ass = 0;
        return isset($this->property_profit_total[$property])
            ? $this->property_profit_total[$property] - $ass
            : 0;
    }

    /**
     * @param int $name category_name
     * @return int|array
     */
    public function getCategory_total($name = NULL){
        if($name){
            return isset($this->category_total[$name]) 
                ? $this->category_total[$name] : NULL;
        } return $this->category_total;   
    }

    /**
     * @param int $id property_id
     * @return array
     */
    public function getProperty_category_total($id = NULL){
        if($id){
            return isset($this->property_category_total[$id]) 
                ? $this->property_category_total[$id] : NULL;
        } return $this->property_category_total;   
    }

    /**
     * @param int $id property_id
     * @return int|array
     */
    public function getProperty_total($id = NULL){
        if($id){
            if($id == $this->head_quarter_id)
                return $this->getProperty_profit_total($id);
            return isset($this->property_total[$id]) 
                ? $this->property_total[$id] : NULL;
        } return $this->property_total;
    }

    /**
     * @param Expense $expense
     */
    public function addExpense(Expense $e){
        $this->setProperty($e->getProperty());
        $this->setYtd($e);
        $this->expense[] = $e;
        return $this;
    }

    /**
     * @param Expense $expense
     */
    public function addIncome(Income $i){
        $this->setProperty($i->getProperty());
        $this->setYtd($i);
        $this->income[] = $i;
        return $this;
    }

    private function setProperty(Property $p){
        if(!isset($this->property[$p->getId()])){
            $this->property[$p->getId()] = $p;
            if($p->getId() != $this->head_quarter_id && $p->getStatus_id() != $this->disabled_status)
                $this->property_count ++;            
        }
    }

    /**
     * @return int $id property_id
     */
    public function getProperty($id){
        return isset($this->property[$id])
            ? $this->property[$id] : NULL;
    }

    /**
     * @return int
     */
    public function getHead_quarter_id(){
        return $this->head_quarter_id;
    }

    /**
     * @return int
     */
    public function getProperty_count(){
        return $this->property_count;
    }

    /**
     * @param int $id property_id
     * @return int
     */
    public function getProperty_months_in_service($id){
        if(isset($this->property_start[$id])){
            $now = date_create(date('Y-m-d'));
            $start = date_create($this->property_start[$id]);
            $interval = date_diff($start, $now);
            $months_in_service = (int)$interval->format('%m');
            if((int)$yis = $interval->format('%y'))
                $months_in_service += ($yis*12);
            return $months_in_service;
        } return 0;
    }
}