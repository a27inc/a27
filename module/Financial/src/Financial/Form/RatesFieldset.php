<?php namespace Financial\Form;

use Financial\Entity\Rate;
use Zend\Form\Fieldset;
use Zend\Hydrator\ObjectProperty;

class RatesFieldset extends Fieldset{
    public function __construct(){
        parent::__construct('rate_fieldset');
        $this->setHydrator(new ObjectProperty())
            ->setObject(new Rate());
        
        $this->add([
            'type' => 'hidden',
            'name' => 'id',
            'attributes' => [
                'value' => 5
            ]]);
    }
}