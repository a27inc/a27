<?php namespace Landlord\Form;

use Landlord\Entity\Tenant;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Between;
use Zend\Validator\Date;
use Zend\Validator\Regex;

class TenantFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'tenants'){
        parent::__construct($name);

        $this->setHydrator(new ObjectProperty())
            ->setObject(new Tenant());

        $this->add([
            'name' => 'id',
            'type' => 'Hidden']);

        $this->add([
            'name' => 'firstName',
            'type' => 'Text',
            'options' => [
                'label' => 'First Name: ']]);

        $this->add([
            'name' => 'middleInitial',
            'type' => 'Text',
            'options' => [
                'label' => 'Middle Initial: ']]);

        $this->add([
            'name' => 'lastName',
            'type' => 'Text',
            'options' => [
                'label' => 'Last Name: ']]);

        $this->add([
            'type' => 'Date',
            'name' => 'birthDate',
            'options' => [
                'label' => 'Birth Date: '],
            'attributes' => [
                'placeholder' => 'yyyy-mm-dd'
            ]
        ]);

        $this->add([
            'name' => 'code',
            'type' => 'Text',
            'options' => [
                'label' => 'Code: ']]);
	}

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        
        $text_filters = [
            ['name' => 'StringTrim'],
            ['name' => 'StripTags']
        ];

        return [
            'firstName' => [
                'required' => true,
                'filters' => $text_filters,
                'validators' => [
                    ['name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[- a-zA-Z]{1,32}$/',
                            'messages' => [
                                Regex::NOT_MATCH => 'Please enter 1-32 alphabetical characters (A-Z, a-z, -dash, space)',
                            ]
                        ]
                    ]
                ]
            ],

            'middleInitial' => [
                'required' => false,
                'filters' => $text_filters,
                'validators' => [
                    ['name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[a-zA-Z]$/',
                            'messages' => [
                                Regex::NOT_MATCH => 'Please enter one uppercase alphabetical character (A-Z)',
                            ]
                        ]
                    ]
                ]
            ],

            'lastName' => [
                'required' => true,
                'filters' => $text_filters,
                'validators' => [
                    ['name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[-a-zA-Z]{1,32}$/',
                            'messages' => [
                                Regex::NOT_MATCH => 'Please enter 1-32 alphabetical characters (A-Z, a-z, -dash)',
                            ]
                        ]
                    ]
                ]
            ],

            'birthDate' => [
                'required' => true,
                'filters' => $text_filters,
                'validators' => [
                    [
                        'name' => 'Date',
                        'break_chain_on_failure' => true,
                        'options' => [
                            'format'    => 'Y-m-d',
                            'messages' => [
                                Date::INVALID_DATE => 'The input does not fit the date format "%format%"'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Between',
                        'options' => [
                            'min' => date('Y-m-d', strtotime('-110 years')),
                            'max' => date('Y-m-d', strtotime('-16 years')),
                            'messages' => [
                                Between::NOT_BETWEEN => 'Tenant must be at least 16 years of age, but also younger than dirt'
                            ]
                        ]
                    ]
                ]
            ],

            'code' => [
                'required' => false,
                'filters' => $text_filters,
                'validators' => [
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[A-Z0-9]{1,64}$/',
                            'messages' => [
                                Regex::NOT_MATCH => 'Please enter 1-64 uppercase alphanumeric characters. (A-Z, 0-9)',
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}