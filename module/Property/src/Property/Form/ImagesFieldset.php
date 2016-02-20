<?php namespace Property\Form;

use Property\Entity\PropertyImage;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class ImagesFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct($name = 'images', $options = array()){
        parent::__construct($name);
        
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new PropertyImage());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
            'attributes' => array(
                'data-field' => 'id')));

        $this->add(array(
            'name' => 'property_id',
            'type' => 'Hidden',
            'attributes' => array(
                'data-field' => 'property_id')));

        $this->add(array(
            'name' => 'file',
            'type' => 'Hidden',
            'attributes' => array(
                'data-field' => 'file')));

        $this->add(array(
            'name' => 'remove',
            'type' => 'Hidden',
            'attributes' => array(
                'data-field' => 'remove')));

        $this->add(array(
            'name' => 'image_file',
            'type' => 'file',
            'attributes' => array(
                'multiple' => false,
                'data-field' => 'image_file'),
            'options' => array(
                'label' => 'Image Upload: ')));

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name: '),
            'attributes' => array(
                'data-field' => 'name')));

        $this->add(array(
            'name' => 'description',
            'type' => 'Text',
            'options' => array(
                'label' => 'Description: '),
            'attributes' => array(
                'data-field' => 'description')));

        $this->add(array(
            'name' => 'remove_image',
            'type' => 'button',
            'options' => array('label' => 'Remove'),
            'attributes' => array(
                'data-field' => 'remove_image',
                'data-action' => 'remove')));
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
            'property_id' => array(
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
            'image_file' => array(
                'required' => false,
                'validators' => array(
                    array('name' => 'filesize',
                        'options' => array(
                            'max' => '400kB')),
                    array('name' => 'filemimetype',
                        'options' => array(
                            'mimeType' => 'image/jpg, image/jpeg')),        
                    array('name' => 'fileimagesize',
                        'options' => array(
                            'maxWidth' => 1024,
                            'maxHeight' => 768)),    
                    array('name' => 'fileextension',
                        'options' => array(
                            'extension' => 'jpg'))
                ),
                'filters' => array(
                    array('name' => 'filerenameupload',
                        'options' => array(
                            'target' => 'public/images/property/temp',
                            'randomize' => true,
                            'use_upload_extension' => true))
                )
            ),
            'file' => array(
                'required' => false,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^(property|temp)_[a-z0-9]{13}\.jpg$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^(property|temp)_[a-z0-9]{13}\.jpg$',
                            )
                        )
                    )
                )
            ),
            'name' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[- a-zA-Z0-9]{1,32}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[- a-zA-Z0-9]{1,32}$',
                            )
                        )
                    )
                )
            ),
            'description' => array(
                'required' => true,
                'filters' => $text_filters,
                'validators' => array(
                    array('name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[-+,.?"\/\'!&*() a-zA-Z0-9]{1,64}$/',
                            'messages' => array(
                                \Zend\Validator\Regex::NOT_MATCH => 'Non match: ^[-+,.?"/\'!&*() a-zA-Z0-9]{1,64}$',
                            )
                        )
                    )
                )
            )
        );
    }
}