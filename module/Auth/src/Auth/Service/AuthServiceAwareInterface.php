<?php namespace Auth\Service;

use Zend\Authentication\AuthenticationService;

interface AuthServiceAwareInterface{
    public function setAuthService(AuthenticationService $s);
}