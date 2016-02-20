<?php namespace Investor\Form;

use Investor\Entity\Category;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class CategoryFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'category', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new Category());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name: ')));

        $this->add(array(
            'name' => 'symbol',
            'type' => 'Text',
            'options' => array(
                'label' => 'Symbol: ')));

        $this->add(array(
            'name' => 'display_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Display Name: ')));

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

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        
        $text_filters = array(
            array('name' => 'StringTrim'),
            array('name' => 'StripTags')
        );

        return array(
            'name' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[a-z][-a-z]{1,63}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Please enter 1-64 alphabetical characters (a-z, -dash)',
                            ))))));

            
    }
}