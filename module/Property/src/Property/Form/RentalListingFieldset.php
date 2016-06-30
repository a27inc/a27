<?php namespace Property\Form;

use Property\Entity\RentalListing;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilterProviderInterface;

class RentalListingFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'rental_listing', $options = array()){
        parent::__construct($name);
        
        $this->setHydrator(new ObjectProperty())
            ->setObject(new RentalListing());

        $this->add(array(
            'name' => 'rent',
            'type' => 'Text',
            'options' => array(
                'label' => 'Rent: ')));

        $this->add(array(
            'name' => 'deposit',
            'type' => 'Text',
            'options' => array(
                'label' => 'Deposit: ')));

        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'available',
            'options' => array(
                'label' => 'Date Available: '),
            'attributes' => array(
                'min' => '2014-01-01',
                'max' => '2020-01-01',
                'step' => '1')));

        $this->add(array(
            'name' => 'contactName',
            'type' => 'Text',
            'options' => array(
                'label' => 'Contact Name: ')));

        $this->add(array(
            'name' => 'contactNumber',
            'type' => 'Text',
            'options' => array(
                'label' => 'Contact Number: ')));

        $this->add(array(
            'name' => 'summary',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Listing Summary: ')));

        $this->add(array(
            'name' => 'notes',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Listing Notes: ')));

        $this->add(array(
            'name' => 'ctaButton',
            'type' => 'Text',
            'options' => array(
                'label' => 'CTA Button Text: ')));

        $this->add(array(
            'name' => 'ctaTitle',
            'type' => 'Text',
            'options' => array(
                'label' => 'CTA Heading: ')));

        $this->add(array(
            'name' => 'ctaMessage',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'CTA Message: ')));

        $this->add(array(
            'name' => 'ctaFooter',
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
            'rent' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => $pat1,
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: '.trim($pat1, '/')
                            )
                        )
                    )
                )
            ),
            'deposit' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => $pat1,
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: '.trim($pat1, '/')
                            )
                        )
                    )
                )
            ),
            'contactName' => array(
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
            'contactNumber' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[-1-9]{10,12}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[-1-9]{10,12}$',
                            )
                        )
                    )
                )
            )
        );
    }
}