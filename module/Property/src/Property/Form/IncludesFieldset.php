<?php namespace Property\Form;

use Property\Entity\PropertyInclude;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class IncludesFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'includes', $options = array()){
        parent::__construct($name);
        
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new PropertyInclude());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
            'attributes' => array(
                'data-field' => 'id')));

        $this->add(array(
            'name' => 'property_id',
            'type' => 'Hidden',
            'attributes' => array(
                'data-field' => 'property_id')));

        $this->add(array(
            'name' => 'remove',
            'type' => 'Hidden',
            'attributes' => array(
                'data-field' => 'remove')));

        $this->add(array(
            'name' => 'include',
            'type' => 'Text',
            'options' => array(
                'label' => 'Include: '),
            'attributes' => array(
                'data-field' => 'include')));

        $this->add(array(
            'name' => 'remove_include',
            'type' => 'button',
            'options' => array('label' => 'Remove'),
            'attributes' => array(
                'data-field' => 'remove_include',
                'data-action' => 'remove')));
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
            'id' => array(
                'required' => false,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^(?!0)[0-9]{1,11}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^(?!0)[0-9]{1,11}$',
                            )
                        )
                    )
                )
            ),
            'property_id' => array(
                'required' => false,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^(?!0)[0-9]{1,11}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^(?!0)[0-9]{1,11}$',
                            )
                        )
                    )
                )
            ),
            'include' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[-\/ a-zA-Z0-9]{1,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[-/ a-zA-Z0-9]{1,32}$',
                            )
                        )
                    )
                )
            )
        );
    }
}