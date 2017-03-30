<?php namespace Property\Form;

use Property\Entity\Extra;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator\Regex;

class ExtrasFieldset extends Fieldset implements InputFilterProviderInterface{

    protected $serviceLocator;
    protected $extraOptions;
    
    public function __construct(ServiceLocatorInterface $sl, $name = 'extras'){
        $this->serviceLocator = $sl;
        parent::__construct($name);
        
        $this->setHydrator(new ObjectProperty())
            ->setObject(new Extra());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Extra: ',
                'empty_option' => 'Please select extra...',
                'value_options' => $this->getExtraOptions()),
            'attributes' => array(
                'required' => 'required')));

        $this->add(array(
            'name' => 'removeExtra',
            'type' => 'button',
            'options' => array('label' => 'Remove'),
            'attributes' => array(
                'data-action' => 'delete')));
	}

    protected function getExtraOptions() {
        if (is_null($this->extraOptions)) {
            $service = $this->serviceLocator->get('Property/PropertyService');
            $this->extraOptions = $service->getExtraOptions();
        }
        return $this->extraOptions['extra'];
    }

    /**
     * @return array
     */
    public static function getInputFilterConfig() {
        $text_filters = array(
            array('name' => 'StringTrim'),
            array('name' => 'StripTags')
        );

        return array(
            'id' => array(
                'required' => false,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                          'options' => array(
                              'pattern' => '/^(?!0)[0-9]{1,11}$/',
                              'messages' => array(
                                  Regex::NOT_MATCH => 'Non match: ^(?!0)[0-9]{1,11}$',
                              )
                          )
                    )
                )
            )
        );
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        return self::getInputFilterConfig();
    }
}