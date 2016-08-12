<?php namespace Financial\Form;

use Financial\Entity\Income;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\Validator\Between;
use Zend\Validator\Date;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Regex;

class IncomeFieldset extends Fieldset implements InputFilterProviderInterface{
	public function init(){
        $this->add([
            'name' => 'id',
            'type' => 'Hidden']);
        $this->add([
            'name' => 'property',
            'type' => 'PropertiesFieldset']);
        $this->add([
            'name' => 'category',
            'type' => 'CategoriesFieldset']);
        $this->add([
            'name' => 'rate',
            'type' => 'RatesFieldset']);
        $this->add([
            'name' => 'amount',
            'type' => 'Text',
            'options' => [
                'label' => 'Amount: '],
            'attributes' => [
                'placeholder' => '9999.99'
            ]]);
        $this->add([
            'type' => 'Date',
            'name' => 'dateFiled',
            'options' => [
                'label' => 'Date: '],
            'attributes' => [
                'value' => date('Y-m-d')]]);
        /*$this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_from',
            'options' => [
                'label' => 'Recurring From: '],
            'attributes' => [
                'min' => '2014-01-01',
                'max' => '2020-01-01',
                'step' => '1']]);
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_to',
            'options' => [
                'label' => 'Recurring To: '],
            'attributes' => [
                'min' => '2014-01-01',
                'max' => '2020-01-01',
                'step' => '1']]);*/
        $this->add([
            'name' => 'description',
            'type' => 'Textarea',
            'options' => [
                'label' => 'Description: ']]);
        $this->add([
            'name' => 'note',
            'type' => 'Textarea',
            'options' => [
                'label' => 'Note: ']]);
    }

    public function __construct($name = 'income', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ObjectProperty())
            ->setObject(new Income());
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

        $pat1 = '/^(0|([1-9][0-9]{0,6}|[1-9][0-9]{0,6}[.][1-9][0-9]?))$/';

        return [
            'amount' => [
                'required' => true,
                'filters' => $text_filters,
                'validators' => [
                    ['name' => 'Regex',
                        'options' => [
                            'pattern' => $pat1,
                            'messages' => [
                                Regex::NOT_MATCH => 'Non match: '.trim($pat1, '/')
                            ]
                        ]
                    ]
                ]
            ],
            'dateFiled' => [
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