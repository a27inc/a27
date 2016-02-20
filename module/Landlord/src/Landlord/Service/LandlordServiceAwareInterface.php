<?php namespace Landlord\Service;

interface LandlordServiceAwareInterface{
    public function setLandlordService(LandlordService $s);
}