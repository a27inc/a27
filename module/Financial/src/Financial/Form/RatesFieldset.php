<?php namespace Financial\Form;

//use Financial\Model\RatesTable;
use Financial\Entity\Rate;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class RatesFieldset extends Fieldset{
    public function __construct(){
        parent::__construct('rate_fieldset');
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Rate());
        
        $this->add(array(
            'name' => 'rate_id',
            'type' => 'hidden',
            'value' => 5));
    }

    /*public function setRatesTable(RatesTable $rt){
        $this->add(array(
            'name' => 'rate_id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Term: ',
                'empty_option' => 'Please select term...',
                'value_options' => $rt->getOptions())));   
    }*/
}