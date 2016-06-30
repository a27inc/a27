<?php namespace SiteUser\Form;

use SiteUser\Entity\Role;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilterProviderInterface;
use SiteUser\Model\PermissionsTableAwareInterface;
use SiteUser\Model\RolesTableAwareInterface;
use SiteUser\Model\PermissionsTable;
use SiteUser\Model\RolesTable;
use Zend\Validator\Regex;

class RoleFieldset extends Fieldset implements InputFilterProviderInterface, PermissionsTableAwareInterface, RolesTableAwareInterface{

    public function __construct($name = 'role', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ObjectProperty())
            ->setObject(new Role());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array('label' => 'Name: ')));
    }

    public function setPermissionsTable(PermissionsTable $t){
        $this->add(array(
            'name' => 'permissionIds',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'multiple' => 'multiple'
            ),
            'options' => array(
                'label' => 'Permissions: ',
                'value_options' => $t->getOptions())));
    }

    public function setRolesTable(RolesTable $t){
        $this->add(array(
            'name' => 'childId',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Child Role: ',
                'value_options' => $t->getOptions())));
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
                            'pattern' => '/^[a-z][_a-z]{1,47}$/',
                            'messages' => array(
                                Regex::NOT_MATCH => 'Please enter 1-48 lowercase alphabetical characters (a-z, _underscore)',
                            ))))));
    }
}