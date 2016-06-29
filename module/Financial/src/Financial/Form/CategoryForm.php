<?php namespace Financial\Form;

use Zend\Form\Form;

class CategoryForm extends Form{
	public function __construct($name = 'category_form', $options = array()){
		parent::__construct($name);

        $this->add(array(
            'type' => 'Financial\Form\CategoryFieldset',
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