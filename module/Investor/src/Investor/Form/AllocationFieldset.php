<?php namespace Investor\Form;

use Investor\Entity\Allocation;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class AllocationFieldset extends Fieldset implements InputFilterProviderInterface{
	public function init(){
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'investor',
            'type' => 'UsersFieldset'));

        $this->add(array(
            'name' => 'category',
            'type' => 'AllocationCategoriesFieldset'));

        $this->add(array(
            'name' => 'property',
            'type' => 'PropertiesFieldset'));

        $this->add(array(
            'name' => 'allocation',
            'type' => 'Text',
            'options' => array(
                'label' => 'Allocation: ')));

        $this->add(array(
            'name' => 'note',
            'type' => 'Text',
            'options' => array(
                'label' => 'Note: ')));

	}

    public function __construct($name = 'allocation', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new Allocation());
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
            'allocation' => array(
                'required' => true,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[1-9][0-9]{0,6}([.][0-9]{1,2})?$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Please enter up to a 9 digit floating number: xxxxxxx.xx',
                            ))))),
            'note' => array(
                'required' => false,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[-+=!.,:;@#$%&*\/() a-zA-Z]{0,255}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[-+=!.,:;@#$%&*\/() a-zA-Z]{0,255}$',
                            )
                        )
                    )
                ),
                'filters' => $text_filters 
            ));
    }
}