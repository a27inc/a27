<?php namespace Landlord\Form;

use Zend\Form\Form;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilter;

class TenantForm extends Form{
	public function __construct($name = 'tenant_form', $options = array()){
		parent::__construct($name);

        $this->setAttribute('method', 'post')
            ->setHydrator(new ObjectProperty())
            ->setInputFilter(new InputFilter());

        $this->add(array(
            'type' => 'Landlord\Form\TenantFieldset',
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