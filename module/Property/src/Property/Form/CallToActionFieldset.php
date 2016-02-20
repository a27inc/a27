<?php namespace Property\Form;

use Property\Entity\CallToAction;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class CallToActionFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'call_to_action', $options = array()){
        parent::__construct($name);
        
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new CallToAction());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'cta_button',
            'type' => 'Text',
            'options' => array(
                'label' => 'CTA Button Text: ')));

        $this->add(array(
            'name' => 'cta_title',
            'type' => 'Text',
            'options' => array(
                'label' => 'CTA Heading: ')));

        $this->add(array(
            'name' => 'cta_message',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'CTA Message: ')));

        $this->add(array(
            'name' => 'cta_footer',
            'type' => 'Text',
            'options' => array(
                'label' => 'CTA Footer Message: ')));
	}

    /**
     * @return array
     */
    public function getInputFilterSpecification(){
        
        $text_filters = array(
            array('name' => 'StringTrim'),
            array('name' => 'StripTags')
        );

        $text2_filters = array(
            array('name' => 'StringTrim'),
            array('name' => 'StripTags'),
            array('name' => 'StringToUpper')
        );

        $pat1 = '/^(0|([1-9][-0-9]{0,3}|[1-9][0-9]{0,3}[.][0-9]{2}))$/';

        return array(
            'id' => array(
                'required' => false,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^(?!0)[0-9]{1,11}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^(?!0)[0-9]{1,11}$',
                            )
                        )
                    )
                )
            ),
            'cta_button' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[!& a-zA-Z]{2,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[!& a-zA-Z]{2,32}$',
                            )
                        )
                    )
                )
            ),
            'cta_title' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[ a-zA-Z]{2,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[ a-zA-Z]{2,32}$',
                            )
                        )
                    )
                )
            ),
            'cta_message' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[.,\/!#%$&@*\'(+=) a-zA-Z]{2,256}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[.,\/!#%$@&*\'(+=) a-zA-Z]{2,256}$',
                            )
                        )
                    )
                )
            ),
            'cta_footer' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[.,!#%$&@*\'(+=) a-zA-Z]{2,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[.,!#%$&@*\'(+=) a-zA-Z]{0,32}$',
                            )
                        )
                    )
                )
            )
        );
    }
}