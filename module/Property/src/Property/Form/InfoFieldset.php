<?php namespace Property\Form;

use Property\Entity\Info;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Callback;
use Zend\Validator\Regex;

class InfoFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'info', $options = array()){
        parent::__construct($name);
        
        $this->setHydrator(new ObjectProperty())
            ->setObject(new Info());

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
            'name' => 'propertyTaxes',
            'type' => 'Text',
            'options' => array(
                'label' => 'Annual Property Taxes: ')));

        $this->add(array(
            'name' => 'hoaFees',
            'type' => 'Text',
            'options' => array(
                'label' => 'HOA Fees: ')));

        $this->add(array(
            'name' => 'yearBuilt',
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

        $pat1 = '/^[0-9]{0,4}[.]?[0-9]{1,2}$/';

        return array(
            'sqft' => array(
                'required' => false,
                'allow_empty' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                Callback::INVALID_VALUE => 'Non match: ^([0-9]{3,4})$',
                            ),
                            'callback' => function($value, $context = array()){
                                if(isset($context['statusId']) && $context['statusId'] == 3)
                                    return TRUE;
                                return (bool) preg_match('/^([0-9]{3,4})*$/', $value);
                            }
                        )
                    )
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
                                Regex::NOT_MATCH => 'Non match: ^[1-9]$',
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
                            'pattern' => '/^[1-9][.]?[025]?[05]?$/',
                            'messages' => array(
                                Regex::NOT_MATCH => 'Non match: ^[1-9][.]?[025]?[05]?$',
                            )
                        )
                    )
                ) 
            ),
            'propertyTaxes' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => $pat1,
                            'messages' => array(
                                Regex::NOT_MATCH => 'Non match: '.trim($pat1, '/')
                            )
                        )
                    )
                )
            ),
            'hoaFees' => array(
                'required' => false,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => $pat1,
                            'messages' => array(
                                Regex::NOT_MATCH => 'Non match: '.trim($pat1, '/')
                            )
                        )
                    )
                )
            ),
            'yearBuilt' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[1-2](0|[8-9])([0-9]{2})*$/',
                            'messages' => array(
                                Regex::NOT_MATCH => 'Non match: ^[1-2](0|[8-9])([0-9]{2})$',
                            )
                        )
                    )
                )
            )
        );
    }
}