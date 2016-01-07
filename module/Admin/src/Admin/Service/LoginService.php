<?php

namespace Admin\Service;

use Zend\Authentication\AuthenticationServiceInterface;

class LoginService
{
    protected $authenticationService;
    
    public function __construct(AuthenticationServiceInterface $authService)
    {
        $this->setAuthenticationService($authService);
    }
    
    /**
     * @param array $loginData
     * @return boolean
     */
    public function doLogin($loginData)
    {
        $username = $loginData['username'];
        $password = $loginData['password']; 
        
        $this->getAuthenticationService()->getAdapter()->setIdentity($username);
        $this->getAuthenticationService()->getAdapter()->setCredential($password);
        
        $result = $this->getAuthenticationService()->authenticate();
        
        return $result->isValid(); 
    }
    
    public function setAuthenticationService($authService)
    {
        $this->authenticationService = $authService;
    }
    
    /**
     * @return AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }
}