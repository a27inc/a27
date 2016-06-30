<?php namespace Application\Model;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Hydrator\Aggregate\AggregateHydrator;
use Financial\Hydrator\IncomeHydrator;
use Financial\Hydrator\ExpenseHydrator;

class ModelAbstractInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $sl){
        if($instance instanceof ModelAbstract){
            $adapter = $sl->get('Zend\Db\Adapter\Adapter');
            $instance->setDbAdapter($adapter);
            //$hydrator = new AggregateHydrator();
            //$hydrator->add(new IncomeHydrator());
            //$hydrator->add(new ExpenseHydrator());
            //$instance->setHydrator($hydrator);
        }
    }
}