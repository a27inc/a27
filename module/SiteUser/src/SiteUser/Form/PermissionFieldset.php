<?php namespace SiteUser\Form;

use SiteUser\Entity\Permission;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Regex;

class PermissionFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'permission', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ObjectProperty())
            ->setObject(new Permission());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name: ')));
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
                            'pattern' => '/^[a-z][_a-z]{1,127}$/',
                            'messages' => array(
                                Regex::NOT_MATCH => 'Please enter 1-128 lowercase alphabetical characters (a-z, _underscore)',
                            ))))));

            
    }
}