<?php namespace Financial\Form;

use Financial\Model\CategoriesTableAwareInterface;
use Financial\Model\CategoriesTable;
use Financial\Entity\Category;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CategoriesFieldset extends Fieldset implements CategoriesTableAwareInterface{
    public function __construct(){
        parent::__construct('categories_fieldset');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Category());
    }

    public function setCategoriesTable(CategoriesTable $ct){
        $this->add(array(
            'name' => 'category_id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Category: ',
                'empty_option' => 'Please select category...',
                'value_options' => $ct->getOptions())));  
    }
}