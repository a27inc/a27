<?php namespace SiteUser\Form;

use SiteUser\Entity\User;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class UserFieldset extends Fieldset implements InputFilterProviderInterface{
	public function init(){
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'options' => array('label' => 'Email: ')));

        $this->add(array(
            'name' => 'displayname',
            'type' => 'Text',
            'options' => array('label' => 'Display Name: ')));

        $this->add(array(
            'name' => 'role',
            'type' => 'RolesFieldset'));
	}

    public function __construct($name = 'user', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new User());
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
            'displayname' => array(
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