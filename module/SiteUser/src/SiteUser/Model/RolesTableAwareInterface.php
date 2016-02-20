<?php namespace SiteUser\Model;

interface RolesTableAwareInterface{
    public function setRolesTable(RolesTable $rs);
}