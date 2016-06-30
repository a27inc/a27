<?php namespace SiteUser\Form;

use Zend\Form\Form;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilter;

class PermissionForm extends Form{
	public function __construct($name = 'permission_form', $options = array()){
		parent::__construct($name);

        $this->add(array(
            'type' => 'SiteUser\Form\PermissionFieldset',
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