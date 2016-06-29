<?php namespace Property\Form;

use Property\Entity\Image;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Regex;

class ImagesFieldset extends Fieldset implements InputFilterProviderInterface{

    public function __construct($name = 'images'){
        parent::__construct($name);
        
        $this->setHydrator(new ObjectProperty())
            ->setObject(new Image());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
            'attributes' => array(
                'data-field' => 'id')));

        $this->add(array(
            'name' => 'file',
            'type' => 'Hidden',
            'attributes' => array(
                'data-field' => 'file')));

        $this->add(array(
            'name' => 'imageFile',
            'type' => 'file',
            'attributes' => array(
                'multiple' => false,
                'data-field' => 'imageFile'),
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
            'name' => 'removeImage',
            'type' => 'button',
            'options' => array('label' => 'Remove'),
            'attributes' => array(
                'data-field' => 'removeImage',
                'data-action' => 'delete')));
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
                                Regex::NOT_MATCH => 'Non match: ^(?!0)[0-9]{1,11}$',
                            )
                        )
                    )
                )
            ),
            'imageFile' => array(
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
                                Regex::NOT_MATCH => 'Non match: ^(property|temp)_[a-z0-9]{13}\.jpg$',
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
                                Regex::NOT_MATCH => 'Non match: ^[- a-zA-Z0-9]{1,32}$',
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
                                Regex::NOT_MATCH => 'Non match: ^[-+,.?"/\'!&*() a-zA-Z0-9]{1,64}$',
                            )
                        )
                    )
                )
            )
        );
    }
}