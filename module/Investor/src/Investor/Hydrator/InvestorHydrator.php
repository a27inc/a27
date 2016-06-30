<?php namespace Investor\Hydrator;

use Application\Hydrator\HydratorAbstract;
use Investor\Entity\Investor;
use SiteUser\Hydrator\UserStrategy;
use Zend\Hydrator\NamingStrategy\CompositeNamingStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\Hydrator\NamingStrategy\UnderscoreNamingStrategy;

class InvestorHydrator extends HydratorAbstract{

    protected function initHydrate() {
        $this->entityTableMap = array(
            '\SiteUser\Entity\User'         => 'user'
        );
    }
    
    protected function initExtract() {
        $namingMap = new MapNamingStrategy([
            'user_id'       => 'user']);
        $underscore = new UnderscoreNamingStrategy();
        $namingStrategies = new CompositeNamingStrategy([
            'user'                              => $namingMap,
            'financialNotificationFrequency'    => $underscore
        ]); 
        
        $this->setNamingStrategy($namingStrategies);
        $this->addStrategy('user_id', new UserStrategy());
    }
}