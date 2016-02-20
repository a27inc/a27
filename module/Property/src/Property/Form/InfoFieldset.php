<?php namespace Property\Form;

use Property\Entity\PropertyInfo;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class InfoFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'info', $options = array()){
        parent::__construct($name);
        
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new PropertyInfo());

        $this->add(array(
            'name' => 'property_id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'sqft',
            'type' => 'Text',
            'options' => array(
                'label' => 'SqFt: ')));

        $this->add(array(
            'name' => 'bedrooms',
            'type' => 'Text',
            'options' => array(
                'label' => 'Rooms: ')));

        $this->add(array(
            'name' => 'bathrooms',
            'type' => 'Text',
            'options' => array(
                'label' => 'Bathrooms: ')));

        $this->add(array(
            'name' => 'property_taxes',
            'type' => 'Text',
            'options' => array(
                'label' => 'Annual Property Taxes: ')));

        $this->add(array(
            'name' => 'hoa_fees',
            'type' => 'Text',
            'options' => array(
                'label' => 'HOA Fees: ')));

        $this->add(array(
            'name' => 'year_built',
            'type' => 'Text',
            'options' => array(
                'label' => 'Year Built: ')));
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
            'sqft' => array(
                'required' => false,
                'allow_empty' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'Non match: ^([0-9]{3,4})$',
                            ),
                            'callback' => function($value, $context = array()){
                                var_dump($context); var_dump($value); //die;
                                if(isset($context['status_id']) && $context['status_id'] == 3)
                                    return TRUE;
                                return (bool) preg_match('/^([0-9]{3,4})*$/', $value);
                            }
                        )
                    ),
                    /*array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^([0-9]{3,4})*$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^([0-9]{3,4})$',
                            )
                        )
                    )*/
                )
            ),
            'bedrooms' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[1-9]$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[1-9]$',
                            )
                        )
                    )
                )
            ),
            'bathrooms' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^([1-9]|[1-9][.][5])$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^([1-9]|[1-9][.][5])$',
                            )
                        )
                    )
                ) 
            ),
            'property_taxes' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => $pat1,
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: '.trim($pat1, '/')
                            )
                        )
                    )
                )
            ),
            'hoa_fees' => array(
                'required' => false,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => $pat1,
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: '.trim($pat1, '/')
                            )
                        )
                    )
                )
            ),
            'year_built' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[1-2](0|[8-9])([0-9]{2})*$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[1-2](0|[8-9])([0-9]{2})$',
                            )
                        )
                    )
                )
            )
        );
    }
}