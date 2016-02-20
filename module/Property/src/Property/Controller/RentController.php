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
            'properties' => $this->service->findAllProperties(array('status_id' => 1)),
            'images' => $this->service->getImagesByProperty(),
        ));
	}

    public function detailsAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $property = $this->service->findProperty($id);

        $amenities = $this->service->extract($property->amenities, 'amenity');
        $features = $this->service->extract($property->features, 'feature');
        $includes = $this->service->extract($property->includes, 'include');

        $meta_desc = $this->service->getMetaDescription($property, $amenities, $features, $includes);
        
        return new ViewModel(array(
            'meta_desc' => $meta_desc,
            'address' => $this->service->getAddress($property),
            'property' => $property,
            'listing' => $property->rental_listing,
            'info' => $property->info,
            'images' => $property->images,
            'features' => $features,
            'amenities' => $amenities,
            'includes' => $includes 
        ));
    }
}