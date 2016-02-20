<?php namespace Landlord\Form;

use Landlord\Entity\Tenant;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class TenantFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'tenants', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new Tenant());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'first_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'First Name: ')));

        $this->add(array(
            'name' => 'middle_initial',
            'type' => 'Text',
            'options' => array(
                'label' => 'Middle Initial: ')));

        $this->add(array(
            'name' => 'last_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Last Name: ')));

        $this->add(array(
            'name' => 'code',
            'type' => 'Text',
            'options' => array(
                'label' => 'Code: ')));
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

            'middle_initial' => array(
                'required' => false,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[a-zA-Z]$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Please enter one alphabetical character (A-Z)',
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

            'code' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[A-Z0-9]{1,64}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Please enter 1-64 alphanumeric characters. LETTERS IN ALL CAPS (A-Z, 0-9)',
                            ))))));
    }
}