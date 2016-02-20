<?php namespace Financial\Model;

interface RatesTableAwareInterface{
    public function setRatesTable(RatesTable $rt);
}