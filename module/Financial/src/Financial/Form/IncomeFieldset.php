<?php namespace Financial\Form;

use Financial\Entity\Income;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class IncomeFieldset extends Fieldset implements InputFilterProviderInterface{
	public function init(){
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));
        $this->add(array(
            'name' => 'property',
            'type' => 'PropertiesFieldset'));
        $this->add(array(
            'name' => 'category',
            'type' => 'CategoriesFieldset'));
        $this->add(array(
            'name' => 'rate',
            'type' => 'RatesFieldset'));
        $this->add(array(
            'name' => 'amount',
            'type' => 'Text',
            'options' => array(
                'label' => 'Amount: ')));
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_filed',
            'options' => array(
                'label' => 'Date: '),
            'attributes' => array(
                'value' => date('Y-m-d'),
                'min' => '2014-01-01',
                'max' => '2020-01-01',
                'step' => '1')));
        /*$this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_from',
            'options' => array(
                'label' => 'Recurring From: '),
            'attributes' => array(
                'min' => '2014-01-01',
                'max' => '2020-01-01',
                'step' => '1')));
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_to',
            'options' => array(
                'label' => 'Recurring To: '),
            'attributes' => array(
                'min' => '2014-01-01',
                'max' => '2020-01-01',
                'step' => '1')));*/
        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Description: ')));
        $this->add(array(
            'name' => 'note',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Note: ')));
    }

    public function __construct($name = 'income', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new Income());
	}

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        return array(
            'date_from' => array(
                'required' => false),
            'date_to' => array(
                'required' => false),
        );         
    }
}