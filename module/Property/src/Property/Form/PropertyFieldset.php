<?php namespace Property\Form;

use Property\Entity\Property;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class PropertyFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'properties', $options = array()){
        parent::__construct($name);

        $this->setHydrator(new ClassMethods(false))
            ->setObject(new Property());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'));

        $this->add(array(
            'name' => 'zpid',
            'type' => 'Text',
            'options' => array('label' => 'ZPID: ')));

        $this->add(array(
            'name' => 'status_id',
            'type' => 'Select',
            'options' => array(
                'label' => 'Status: ',
                'empty_option' => 'Select status...',
                'value_options' => array(
                    1 => 'For Rent', 
                    2 => 'For Sale',
                    3 => 'Disabled')),
            'attributes' => array(
                'required' => 'required',
                'data-toggle' => '.listing-fieldset')));

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array('label' => 'Name: '),
            'attributes' => array('required' => 'required')));

        $this->add(array(
            'name' => 'street_address',
            'type' => 'Text',
            'options' => array('label' => 'Street: '),
            'attributes' => array('required' => 'required')));

        $this->add(array(
            'name' => 'unit',
            'type' => 'Text',
            'options' => array('label' => 'Unit#: ')));

        $this->add(array(
            'name' => 'city',
            'type' => 'Text',
            'options' => array('label' => 'City: '),
            'attributes' => array('required' => 'required')));

        $this->add(array(
            'name' => 'state',
            'type' => 'Text',
            'options' => array('label' => 'State: '),
            'attributes' => array('required' => 'required')));

        $this->add(array(
            'name' => 'zip',
            'type' => 'Text',
            'options' => array('label' => 'Zip: '),
            'attributes' => array('required' => 'required')));

        $this->add(array(
             'type' => 'Property\Form\InfoFieldset',
             'name' => 'info',
             'options' => array('label' => 'Info: '),
             'attributes' => array(
                'id' => 'info_fieldset',
                'class' => 'listing-fieldset',
                'data-toggle-values' => '1,2')));

        $this->add(array(
             'type' => 'Property\Form\RentalListingFieldset',
             'name' => 'rental_listing',
             'options' => array('label' => 'Rental Listing: '),
             'attributes' => array(
                'id' => 'rental_listing_fieldset',
                'class' => 'listing-fieldset',
                'data-toggle-value' => '1')));

        $this->add(array(
            'name' => 'add_image',
            'type' => 'button',
            'options' => array('label' => 'Add Image'),
            'attributes' => array(
                'id' => 'add_image',
                'class' => 'pull-right listing-fieldset',
                'data-action' => 'add',
                'data-toggle-values' => '1,2',
                'data-target' => '#images_fieldset')));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'images',
            'attributes' => array(
                'id' => 'images_fieldset',
                'class' => 'listing-fieldset',
                'data-toggle-values' => '1,2'),
            'options' => array(
                'label' => 'Images: ',
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                     'type' => 'Property\Form\ImagesFieldset'))));

        $this->add(array(
            'name' => 'add_feature',
            'type' => 'button',
            'options' => array('label' => 'Add Feature'),
            'attributes' => array(
                'id' => 'add_feature',
                'class' => 'pull-right listing-fieldset',
                'data-toggle-values' => '1,2',
                'data-action' => 'add',
                'data-target' => '#features_fieldset')));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'features',
            'attributes' => array(
                'id' => 'features_fieldset',
                'class' => 'listing-fieldset',
                'data-toggle-values' => '1,2'),
            'options' => array(
                'label' => 'Features: ',
                'should_create_template' => true,
                'allow_add' => true,
                'count' => 0,
                'target_element' => array(
                     'type' => 'Property\Form\FeaturesFieldset'))));

        $this->add(array(
            'name' => 'add_amenity',
            'type' => 'button',
            'options' => array('label' => 'Add Amenity'),
            'attributes' => array(
                'id' => 'add_amenity',
                'class' => 'pull-right listing-fieldset',
                'data-toggle-values' => '1,2',
                'data-action' => 'add',
                'data-target' => '#amenities_fieldset')));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'amenities',
            'attributes' => array(
                'id' => 'amenities_fieldset',
                'class' => 'listing-fieldset',
                'data-toggle-values' => '1,2'),
            'options' => array(
                'label' => 'Amenities: ',
                'should_create_template' => true,
                'allow_add' => true,
                'count' => 0,
                'target_element' => array(
                     'type' => 'Property\Form\AmenitiesFieldset'))));

        $this->add(array(
            'name' => 'add_include',
            'type' => 'button',
            'options' => array('label' => 'Add Include'),
            'attributes' => array(
                'id' => 'add_include',
                'class' => 'pull-right listing-fieldset',
                'data-toggle-values' => '1,2',
                'data-action' => 'add',
                'data-target' => '#includes_fieldset')));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'includes',
            'attributes' => array(
                'id' => 'includes_fieldset',
                'class' => 'listing-fieldset',
                'data-toggle-values' => '1,2'),
            'options' => array(
                'label' => 'Includes: ',
                'should_create_template' => true,
                'allow_add' => true,
                'count' => 0,
                'target_element' => array(
                     'type' => 'Property\Form\IncludesFieldset'))));
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

        $pat1 = '/^([1-9][-0-9]{0,3}|[1-9][0-9]{0,3}[.][0-9]{2})$/';

        return array(
            'status_id' => array(
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^(?!0)[0-9]{1,2}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^(?!0)[0-9]{1,2}$',
                            )
                        )
                    )
                )
            ),
            'zpid' => array(
                'required' => false,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[0-9]{8,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[0-9]{8,32}$',
                            )
                        )
                    )
                )
            ),
            'name' => array(
                'required' => true,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[A-Za-z][ A-Za-z]{1,63}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[A-Za-z][ A-Za-z]{1,63}$',
                            )
                        )
                    )
                ),
                'filters' => $text_filters 
            ),
            'street_address' => array(
                'required' => true,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[1-9][ A-Za-z0-9]{1,127}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[1-9][ A-Za-z0-9]{1,127}$',
                            )
                        )
                    )
                ),
                'filters' => $text_filters 
            ),
            'unit' => array(
                'required' => false,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[A-Za-z0-9]{1,8}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[A-Za-z0-9]{1,8}$',
                            )
                        )
                    )
                ),
                'filters' => $text2_filters 
            ),
            'city' => array(
                'required' => true,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[ A-Za-z]{1,64}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[ A-Za-z]{1,64}$',
                            )
                        )
                    )
                ),
                'filters' => $text_filters 
            ),
            'state' => array(
                'required' => true,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[A-Za-z]{2}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[A-Za-z]{2}$',
                            )
                        )
                    )
                ),
                'filters' => $text2_filters 
            ),
            'zip' => array(
                'required' => true,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[1-9][0-9]{4}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[1-9][0-9]{4}$',
                            )
                        )
                    )
                ) 
            )
        );
    }
}