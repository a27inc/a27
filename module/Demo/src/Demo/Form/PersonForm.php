<?php namespace Demo\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;

class PersonForm extends Form{
	public function __construct($name = 'person_form', $options = array()){
		parent::__construct($name);

        $this->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods(false))
            ->setInputFilter(new InputFilter());

        $this->add(array(
            'type' => 'Demo\Form\PersonFieldset',
            'options' => array(
                'use_as_base_fieldset' => true)));

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submit-button')));
	}
}