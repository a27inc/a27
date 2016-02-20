<?php namespace Financial\Model;

class Financial{
    public function getDates(){
        if($this->date_from && $this->date_to)
            return $this->date_from.' - '.$this->date_to;
        else return $this->date_filed;
    }

    protected function getFinanceTotal($obj, $end = NULL, $start = NULL){
        if(!$obj->getId())
		return NULL;
	$is_range = $end || $start;
        
	if($obj->getRate()->getId() == 5)
            return $obj->amount;
        
        if($obj->getRate()->getId() && $obj->date_from && $obj->date_to){

            $freq_str = '';
            switch($obj->getRate()->getId()){
                case 1: $freq_str = '1 month'; break;
                case 2: $freq_str = '4 months'; break;
                case 3: $freq_str = '6 months'; break;
                case 4: $freq_str = '1 year'; break;
            }

            if(empty($start)) 
                $start = $obj->date_from;
            if(empty($end)) 
                $end = date('Y-m-d');

            $multiple = 0;
            if($start <= $obj->date_to && $end >= $obj->date_from){
                $inc_date = $obj->date_from;
                while($inc_date <= $end){
                    if($inc_date >= $start && $inc_date <= $end)
                        $multiple++;
                    $inc_date = date('Y-m-d', strtotime($inc_date. ' + '.$freq_str));
                }
            } return $obj->amount*$multiple;     
        } return FALSE;    
    }
}