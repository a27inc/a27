<?php namespace Financial\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ReportForm extends Form{
	public function __construct($name = 'report_form', $options = array()){
		parent::__construct($name);

        $this->setAttribute('method', 'post')
            ->setInputFilter(new InputFilter());

        $this->add(array(
            'type' => 'Financial\Form\ReportFieldset',
            'options' => array(
                'use_as_base_fieldset' => true)));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submit-button')));
	}

    public function init(){
        
    }
}