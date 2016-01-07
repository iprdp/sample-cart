<?php

namespace Admin\Service;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Zend\Authentication\Adapter\Callback as CallbackAdapter;

class AuthenticationService extends ZendAuthenticationService
{
    public function __construct()
    {
        $callbackAdapter = $this->createCallbackAdapter();        
        parent::__construct(null, $callbackAdapter);
    }
    
    protected function createCallbackAdapter() 
    {
        $callbackFunction = function($identity, $password) {
            return ($identity === 'admin') && ($password === 'sunshine');
        };
        
        return new CallbackAdapter($callbackFunction);
    }    
}
