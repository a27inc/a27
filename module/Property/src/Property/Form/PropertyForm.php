<?php namespace Property\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;

class PropertyForm extends Form{
    public function __construct($name = 'property_form', $options = array()){
        parent::__construct($name);

        $this->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods(false))
            ->setInputFilter(new InputFilter());
        
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