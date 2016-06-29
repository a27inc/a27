<?php namespace Property\Form;

use Property\Model\PropertiesTableAwareInterface;
use Property\Model\PropertiesTable;
use Property\Entity\Property;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;

class PropertiesFieldset extends Fieldset implements PropertiesTableAwareInterface{
    public function __construct(){
        parent::__construct('properties_fieldset');
        
        $this->setHydrator(new ObjectProperty())
            ->setObject(new Property());
    }

    public function setPropertiesTable(PropertiesTable $pt){
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Property: ',
                'empty_option' => 'Please select property...',
                'value_options' => $pt->getOptions())));
    }
}