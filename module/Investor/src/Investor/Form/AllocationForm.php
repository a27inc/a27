<?php namespace Investor\Form;

use Zend\Form\Form;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilter;

class AllocationForm extends Form{
    public function init(){
        $this->add(array(
            'type' => 'Investor\Form\AllocationFieldset',
            'options' => array(
                'use_as_base_fieldset' => true)));

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submit-button')));   
    }

    public function __construct($name = 'allocation_form', $options = array()){
        parent::__construct($name);

        $this->setAttribute('method', 'post')
            ->setHydrator(new ObjectProperty())
            ->setInputFilter(new InputFilter());
    }
}