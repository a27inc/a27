<?php namespace Financial\Model;

use Application\Entity\EntityAbstract;

class Financial extends EntityAbstract{
    
    public function getDates($separator = ' - '){
        if($this->dateFrom && $this->dateTo)
            return $this->dateFrom.$separator.$this->dateTo;
        else return $this->dateFiled;
    }

    protected function getFinanceTotal($obj, $end = null, $start = null){
        if(!$obj->getId() || empty($obj->getRate()))
		    return null;
        
	    if($obj->getRate()->getId() == 5)
            return $obj->amount;
        
        if($obj->getRate()->getId() && $obj->dateFrom && $obj->dateTo){

            $freq_str = '';
            switch($obj->getRate()->getId()){
                case 1: $freq_str = '1 month'; break;
                case 2: $freq_str = '4 months'; break;
                case 3: $freq_str = '6 months'; break;
                case 4: $freq_str = '1 year'; break;
            }

            if(empty($start)) 
                $start = $obj->dateFrom;
            if(empty($end)) 
                $end = date('Y-m-d');

            $multiple = 0;
            if($start <= $obj->dateTo && $end >= $obj->dateFrom){
                $inc_date = $obj->dateFrom;
                while($inc_date <= $end){
                    if($inc_date >= $start && $inc_date <= $end)
                        $multiple++;
                    $inc_date = date('Y-m-d', strtotime($inc_date. ' + '.$freq_str));
                }
            } return $obj->amount*$multiple;     
        } return false;    
    }
}