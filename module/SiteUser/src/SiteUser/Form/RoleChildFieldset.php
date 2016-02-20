<?php namespace SiteUser\Form;

use SiteUser\Model\RolesTableAwareInterface;
use SiteUser\Model\RolesTable;
use SiteUser\Entity\RoleChild;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class RoleChildFieldset extends Fieldset implements InputFilterProviderInterface, RolesTableAwareInterface{
    public function __construct(){
        parent::__construct('roles_fieldset');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new RoleChild());
    }

    public function setRolesTable(RolesTable $t){
        $this->add(array(
            'name' => 'child_id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Child Role: ',
                'empty_option' => 'Please select child...',
                'value_options' => $t->getOptions())));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        return array();    
    }
}