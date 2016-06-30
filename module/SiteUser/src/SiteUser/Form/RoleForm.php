<?php namespace SiteUser\Form;

use Zend\Form\Form;

class RoleForm extends Form{
    public function init(){
        $this->add(array(
            'type' => 'SiteUser\Form\RoleFieldset',
            'options' => array(
                'use_as_base_fieldset' => true)));

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submit-button')));   
    }

    public function __construct($name = 'role_form', $options = array()){
        parent::__construct($name);
    }
}