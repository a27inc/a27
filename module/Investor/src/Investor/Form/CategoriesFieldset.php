<?php namespace Investor\Form;

use Investor\Model\InvestorCategoriesTableAwareInterface;
use Investor\Model\CategoriesTable;
use Investor\Entity\Category;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;

class CategoriesFieldset extends Fieldset implements InvestorCategoriesTableAwareInterface{
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
                'label' => 'Allocation Type: ',
                'empty_option' => 'Please allocation type...',
                'value_options' => $ct->getOptions())));
    }
}