<?php namespace Application\Form\View\Helper;

use Zend\Form\View\Helper\FormDate as ZendFormDate;

class FormDate extends ZendFormDate {
    /**
     * Attributes valid for the input tag type="datetime"
     *
     * @var array
     */
    protected $validTagAttributes = [
        'name'           => true,
        'autocomplete'   => true,
        'autofocus'      => true,
        'disabled'       => true,
        'form'           => true,
        'list'           => true,
        'max'            => true,
        'min'            => true,
        'readonly'       => true,
        'required'       => true,
        'step'           => true,
        'type'           => true,
        'value'          => true,
        'placeholder'    => true
    ];   
}