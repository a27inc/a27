<?php namespace SiteUser\Form;

use SiteUser\Model\RolesTableAwareInterface;
use SiteUser\Model\RolesTable;
use SiteUser\Entity\UserRole;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class RolesFieldset extends Fieldset implements RolesTableAwareInterface{
    public function __construct(){
        parent::__construct('roles_fieldset');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new UserRole());
    }

    public function setRolesTable(RolesTable $t){
        $this->add(array(
            'name' => 'ids',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'multiple' => 'multiple'
            ),
            'options' => array(
                'label' => 'Roles: ',
                'value_options' => $t->getOptions())));
    }
}