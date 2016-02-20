<?php namespace SiteUser\Service;

interface UserServiceAwareInterface{
    public function setUserService(UserService $us);
}