<?php namespace Property\Form;

use Property\Entity\Contact;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class RentalListingFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'contact', $options = array()){
        parent::__construct($name);
        
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new Contact());

        $this->add(array(
            'name' => 'property_id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'rent',
            'type' => 'Text',
            'options' => array(
                'label' => 'Rent: ')));

        $this->add(array(
            'name' => 'deposit',
            'type' => 'Text',
            'options' => array(
                'label' => 'Deposit: ')));

        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'available',
            'options' => array(
                'label' => 'Date Available: '),
            'attributes' => array(
                'min' => '2014-01-01',
                'max' => '2020-01-01',
                'step' => '1')));

        $this->add(array(
            'name' => 'contact_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Contact Name: ')));

        $this->add(array(
            'name' => 'contact_number',
            'type' => 'Text',
            'options' => array(
                'label' => 'Contact Number: ')));
	}

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        
        $text_filters = array(
            array('name' => 'StringTrim'),
            array('name' => 'StripTags')
        );

        $text2_filters = array(
            array('name' => 'StringTrim'),
            array('name' => 'StripTags'),
            array('name' => 'StringToUpper')
        );

        $pat1 = '/^(0|([1-9][-0-9]{0,3}|[1-9][0-9]{0,3}[.][0-9]{2}))$/';

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
            'contact_name' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[ a-zA-Z]{2,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[ a-zA-Z]{2,32}$',
                            )
                        )
                    )
                )
            ),
            'contact_number' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[-1-9a-zA-Z]{10,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[-1-9a-zA-Z]{10,32}$',
                            )
                        )
                    )
                )
            )
        );
    }
}