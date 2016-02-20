<?php namespace SiteUser\Form;

use SiteUser\Entity\Role;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class RoleFieldset extends Fieldset implements InputFilterProviderInterface{
	public function init(){
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'role_name',
            'type' => 'Text',
            'options' => array('label' => 'Name: ')));

        $this->add(array(
            'name' => 'child',
            'type' => 'RoleChildFieldset'));

        $this->add(array(
            'name' => 'permission',
            'type' => 'PermissionsFieldset'));
	}

    public function __construct($name = 'role', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new Role());
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
            'role_name' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[a-z][_a-z]{1,47}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Please enter 1-48 alphabetical characters (a-z, _underscore)',
                            ))))));
    }
}