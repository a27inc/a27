<?php namespace SiteUser\Model;

interface PermissionsTableAwareInterface{
    public function setPermissionsTable(PermissionsTable $rs);
}