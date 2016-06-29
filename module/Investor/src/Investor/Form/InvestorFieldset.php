<?php namespace Investor\Form;

use Investor\Entity\Investor;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilterProviderInterface;

class InvestorFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'investor', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ObjectProperty())
            ->setObject(new Investor());
	}

    public function init(){
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'user',
            'type' => 'UsersFieldset'));

        $this->add(array(
            'name' => 'financial_notification_frequency',
            'type' => 'Select',
             'options' => array(
                'label' => 'Financial Notification Frequency: ',
                'empty_option' => 'Please select frequency...',
                'value_options' => Investor::$NOTIFICATION_FREQUENCY_NAMES)));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        return array();
    }
}