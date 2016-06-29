<?php namespace Financial\Form;

use Financial\Model\CategoriesTableAwareInterface;
use Financial\Model\CategoriesTable;
use Financial\Entity\Category;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;

class CategoriesFieldset extends Fieldset implements CategoriesTableAwareInterface{
    public function __construct(){
        parent::__construct('categories_fieldset');
        
        $this->setHydrator(new ObjectProperty())
            ->setObject(new Category());
    }

    public function setCategoriesTable(CategoriesTable $ct){
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Category: ',
                'empty_option' => 'Please select category...',
                'value_options' => $ct->getOptions())));  
    }
}