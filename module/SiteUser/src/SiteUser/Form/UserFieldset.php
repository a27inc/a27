<?php namespace SiteUser\Form;

use SiteUser\Entity\User;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilterProviderInterface;
use SiteUser\Model\RolesTableAwareInterface;
use SiteUser\Model\RolesTable;
use SiteUser\Model\User as UserModel;

class UserFieldset extends Fieldset implements InputFilterProviderInterface, RolesTableAwareInterface{
    public function __construct($name = 'user', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ObjectProperty())
            ->setObject(new User());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'state',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Status: ',
                'value_options' => UserModel::getStateOptions())));

        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'options' => array('label' => 'Email: ')));

        $this->add(array(
            'name' => 'displayName',
            'type' => 'Text',
            'options' => array('label' => 'Display Name: ')));
    }

    public function setRolesTable(RolesTable $t){
        $this->add(array(
            'name' => 'roleIds',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'multiple' => 'multiple'
            ),
            'options' => array(
                'label' => 'Roles: ',
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
            'email' => array(
                'required' => true,
                'filters' => $text_filters 
            ),
            'displayName' => array(
                'required' => true,
                'filters' => $text_filters ,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[ !&#@$()_a-zA-Z0-9]{0,50}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Please enter up to 50 characters [ !&#@$()_a-zA-Z0-9]',
                            ))))));
    }
}