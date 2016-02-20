<?php namespace Property\Model;

interface PropertiesTableAwareInterface{
    public function setPropertiesTable(PropertiesTable $rt);
}