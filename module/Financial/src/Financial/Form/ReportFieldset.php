<?php namespace Financial\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ReportFieldset extends Fieldset implements InputFilterProviderInterface{
    public function __construct($name = 'report', $options = array()){
        parent::__construct($name);

         $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_from',
            'options' => array(
                'label' => 'From: '),
            'attributes' => array(
                'min' => '2014-01-01',
                'max' => '2020-01-01',
                'step' => '1')));

        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_to',
            'options' => array(
                'label' => 'To: '),
            'attributes' => array(
                'min' => '2014-01-01',
                'max' => '2020-01-01',
                'step' => '1')));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        return array();
    }
}