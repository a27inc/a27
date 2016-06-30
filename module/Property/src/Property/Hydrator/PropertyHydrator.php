<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/9/2016
 * Time: 8:29 AM
 */

namespace Property\Hydrator;

use Application\Hydrator\HydratorAbstract;
use Zend\Hydrator\Filter\FilterComposite;
use Zend\Hydrator\Filter\MethodMatchFilter;

class PropertyHydrator extends HydratorAbstract{
    
    protected function initHydrate() {
        $this->entityTableMap = array(
            '\Property\Entity\Info'             => 'propertiesInfo',
            '\Property\Entity\Description'      => 'propertiesDescription',
            '\Property\Entity\RentalListing'    => 'rentalListings',
            '\Property\Entity\Extra'            => 'extra',
            '\Property\Entity\Image'            => 'propertiesImages'
        );

        $this->entitySetterMap = array(
            'Image' => 'add',
            'Extra' => 'add',
        );
    }
    
    protected function initExtract() {
        $exclude = new FilterComposite();
        $exclude->addFilter('info', new MethodMatchFilter('info'), FilterComposite::CONDITION_AND);
        $exclude->addFilter('images', new MethodMatchFilter('images'), FilterComposite::CONDITION_AND);
        $exclude->addFilter('extras', new MethodMatchFilter('extras'), FilterComposite::CONDITION_AND);
        $exclude->addFilter('rentalListing', new MethodMatchFilter('rentalListing'), FilterComposite::CONDITION_AND);
        $exclude->addFilter('saleListing', new MethodMatchFilter('saleListing'), FilterComposite::CONDITION_AND);
        $this->filterComposite->addFilter('excludes', $exclude, FilterComposite::CONDITION_AND);
        
    }
}