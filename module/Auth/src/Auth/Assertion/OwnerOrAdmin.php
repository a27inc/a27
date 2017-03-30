<?php namespace Auth\Assertion;

use ZfcRbac\Assertion\AssertionInterface;
use ZfcRbac\Service\AuthorizationService;

class OwnerOrAdmin implements AssertionInterface {
    /**
     * Check if this assertion is true
     *
     * @param  AuthorizationService $authorization
     * @param  mixed $obj
     * @return bool
     */
    public function assert(AuthorizationService $authorization, $obj = null) {
        if ($authorization->getIdentity()->getId() == $obj->getAuthorId()) {
            return true;
        }
        return $authorization->getIdentity()->hasRole('admin');
    }
}