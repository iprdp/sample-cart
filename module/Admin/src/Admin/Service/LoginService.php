<?php

namespace Admin\Service;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\View\Model\ViewModel;
use Admin\Form\Login as LoginForm;

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
    public function processLoginForm($loginData = array(), ViewModel $viewModel)
    {
        $result = null;
        $form = new LoginForm();
        if (!empty($loginData)) {
            $form->setData($loginData);
            if ($form->isValid()) {
                $validData = $form->getData();
                $result = $this->doLogin(
                    $validData['username'], 
                    $validData['password']
                );
            }
        } 
        
        $viewModel->setVariables([
            'loginResult' => $result,
            'loginForm' => $form,
        ]);
    }
    
    protected function doLogin($username, $password)
    {
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