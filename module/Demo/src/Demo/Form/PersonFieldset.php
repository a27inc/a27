<?php namespace Demo\Form;

use Demo\Entity\Person;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class PersonFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'persons', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new Person());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'first_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'First Name: ')));

        $this->add(array(
            'name' => 'last_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Last Name: ')));

        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'birth_date',
            'options' => array(
                'label' => 'Birth Date: '),
            'attributes' => array(
                'value' => date('Y-m-d'),
                'min' => '1916-01-01',
                'max' => date('Y-m-d'),
                'step' => '1')));

        $this->add(array(
            'name' => 'post_code',
            'type' => 'Text',
            'options' => array('label' => 'Postal Code: '),
            'attributes' => array('required' => 'required')));

	}

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        
        $text_filters = array(
            array('name' => 'StringTrim'),
            array('name' => 'StripTags')
        );

        return array(
            'first_name' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[-a-zA-Z]{1,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Please enter 1-32 alphabetical characters (A-Z, a-z, -dash)',
                            ))))),

            'last_name' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[-a-zA-Z]{1,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Please enter 1-32 alphabetical characters (A-Z, a-z, -dash)',
                            ))))),

            'post_code' => array(
                'required' => true,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[1-9][0-9]{4}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[1-9][0-9]{4}$',
                            ))))));
    }
}