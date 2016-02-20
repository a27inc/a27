<?php namespace Financial\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;

class ExpenseForm extends Form{
	public function init(){
        $this->add(array(
            'type' => 'Financial\Form\ExpenseFieldset',
            'options' => array(
                'use_as_base_fieldset' => true)));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submit-button')));
    }

    public function __construct($name = 'expense_form', $options = array()){
		parent::__construct($name);

        $this->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods(false))
            ->setInputFilter(new InputFilter());
	}
}