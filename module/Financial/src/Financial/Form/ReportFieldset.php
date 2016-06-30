<?php namespace Financial\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Between;
use Zend\Validator\Date;

class ReportFieldset extends Fieldset implements InputFilterProviderInterface{
    public function __construct($name = 'report'){
        parent::__construct($name);

         $this->add([
            'type' => 'Date',
            'name' => 'dateFrom',
            'options' => [
                'label' => 'From: '],
             'attributes' => [
                 'placeholder' => 'yyyy-mm-dd',
                 'value' => date('Y').'-01-01'
             ]
         ]);

        $this->add([
            'type' => 'Date',
            'name' => 'dateTo',
            'options' => [
                'label' => 'To: '
            ],
            'attributes' => [
                'placeholder' => 'yyyy-mm-dd',
                'value' => date('Y-m-d')
            ]
        ]);
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        $text_filters = [
            ['name' => 'StringTrim'],
            ['name' => 'StripTags']
        ];

        $dateValidator = [
            'name' => 'Date',
            'break_chain_on_failure' => true,
            'options' => [
                'format'    => 'Y-m-d',
                'messages' => [
                    Date::INVALID_DATE => 'The input does not fit the date format "%format%"'
                ]
            ]
        ];

        $betweenValidator = [
            'name' => 'Between',
            'options' => [
                'min' => '2014-01-01',
                'max' => date('Y-m-d'),
                'messages' => [
                    Between::NOT_BETWEEN_STRICT => 'Must be between today and 2014'
                ]
            ]
        ];

        return [
            'dateFrom' => [
                'required' => true,
                'filters' => $text_filters,
                'validators' => [
                    $dateValidator,
                    $betweenValidator
                ]
            ],
            'dateTo' => [
                'required' => true,
                'filters' => $text_filters,
                'validators' => [
                    $dateValidator,
                    $betweenValidator
                ]
            ]
        ];
    }
}