<?php namespace Investor\Form;

use Zend\Form\Form;

class InvestorForm extends Form{
	public function __construct($name = 'investor_form', $options = array()){
		parent::__construct($name);
	}

	public function init(){
		$this->add(array(
            'type' => 'Investor\Form\InvestorFieldset',
            'options' => array(
                'use_as_base_fieldset' => true)));
        
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Go',
				'id' => 'submit-button')));
	}
}