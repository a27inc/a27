<?php namespace Property\Form;

use Property\Model\Property;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;

class PropertyInputFilter extends InputFilter {

    /**
     * PropertyInputFilter constructor.
     */
    public function __construct() {
        //$this->add(PropertyFieldset::getInputFilterConfig(), 'propertyFieldset');
        //$this->add(RentalListingFieldset::getInputFilterConfig(), 'rentalListingFieldset');
        //$this->add(InfoFieldset::getInputFilterConfig(), 'infoFieldset');
        //$this->add(ImagesFieldset::getInputFilterConfig(), 'imagesFieldset');
        //$this->add(ExtrasFieldset::getInputFilterConfig(), 'extrasFieldset');
    }

    public function isValid($context = null) {
        $isValid = parent::isValid($context);
        if (!$isValid) {
            foreach ($this->getInvalidInput() as $parentName => $parent) {
                $baseFieldSet = $this->get($parentName);
                if ($baseFieldSet->has('statusId')) {
                    $status = $baseFieldSet->get('statusId')->getRawValue();
                    foreach ($baseFieldSet->getInvalidInput() as $childName => $child) {
                        $child = $baseFieldSet->get($childName);
                        if ($child instanceof  InputFilterInterface) {
                            if ($status == Property::STATUS_DISABLED &&
                                !in_array($childName, ['info', 'rentalListing'])
                            ) {
                                return false;
                            }
                            else if ($status == Property::STATUS_FOR_RENT &&
                                !in_array($childName, ['info'])
                            ) {
                                return false;
                            }
                            else if ($status == Property::STATUS_FOR_SALE &&
                                !in_array($childName, ['rentalListing'])
                            ) {
                                return false;
                            }
                        }
                        else {
                            return false;
                        }
                        return true;
                    }
                }
            }
        }
        return $isValid;
    }
}