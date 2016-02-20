<?php namespace SiteUser\Model;

interface UsersTableAwareInterface{
    public function setUsersTable(UsersTable $rs);
}