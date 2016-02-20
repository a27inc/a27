<?php namespace SiteUser\Form;

use SiteUser\Model\UsersTableAwareInterface;
use SiteUser\Model\UsersTable;
use SiteUser\Entity\User;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class UsersFieldset extends Fieldset  implements InputFilterProviderInterface, UsersTableAwareInterface{
    public function __construct(){
        parent::__construct('users_fieldset');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new User());
    }

    public function setUsersTable(UsersTable $t){
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Investor: ',
                'empty_option' => 'Please select an Investor...',
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

        return array();   
    }
}