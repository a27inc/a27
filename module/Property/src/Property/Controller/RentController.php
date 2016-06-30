<?php namespace Property\Controller;

use Property\Service\PropertyServiceAwareInterface;
use Property\Service\PropertyService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RentController extends AbstractActionController implements PropertyServiceAwareInterface{
    protected $service;

    public function setPropertyService(PropertyService $s){
        $this->service = $s;
    }

    public function indexAction(){
        return new ViewModel(array(
            'properties' => $this->service->findAll(array('status_id' => 1), true),
        ));
	}

    public function detailsAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $property = $this->service->find($id, true);

        return new ViewModel(array(
            'meta_desc' => $property->getMetaDescription(),
            'address' => $property->getAddress(),
            'property' => $property,
            'listing' => $property->getRentalListing(),
            'info' => $property->getInfo(),
            'images' => $property->getImages(),
            'amenities' => $property->getAmenities(),
            'features' => $property->getFeatures(),
            'includes' => $property->getIncludes()
        ));
    }
}