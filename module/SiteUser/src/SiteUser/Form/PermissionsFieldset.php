<?php namespace SiteUser\Form;

use SiteUser\Model\PermissionsTableAwareInterface;
use SiteUser\Model\PermissionsTable;
use SiteUser\Entity\RolePermission;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class PermissionsFieldset extends Fieldset  implements InputFilterProviderInterface, PermissionsTableAwareInterface{
    public function __construct(){
        parent::__construct('permissions_fieldset');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new RolePermission());
    }

    public function setPermissionsTable(PermissionsTable $t){
        $this->add(array(
            'name' => 'ids',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'multiple' => 'multiple'
            ),
            'options' => array(
                'label' => 'Permissions: ',
                'empty_option' => 'Please select permissions...',
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
            'ids' => array(
                'required' => false,
            )
        );   
    }
}