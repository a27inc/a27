<?php namespace Property\Form;

use Zend\Form\Form;

class PropertyForm extends Form{
    public function __construct($name = 'property_form', $options = array()){
        parent::__construct($name);
        $this->setInputFilter(new PropertyInputFilter());
    }

    public function init() {
        $this->add(array(
            'type' => 'Property\Form\PropertyFieldset',
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