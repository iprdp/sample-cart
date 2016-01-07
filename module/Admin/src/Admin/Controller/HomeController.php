<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Doctrine\Common\Persistence\ObjectManager;
use Admin\Service\LoginService;

class HomeController extends AbstractActionController 
{
    protected $authenticationService;
    
    protected $loginService;
    
    public function __construct(
        AuthenticationService $authService, 
        LoginService $loginService
    ) {
        $this->setAuthenticationService($authService);
        $this->setLoginService($loginService);
    }
    
	public function homeAction() 
	{
	    if (!$this->getAuthenticationService()->hasIdentity()) {
	        $this->redirect()->toRoute('admin_login');
	    }

	    $this->redirect()->toRoute('admin_categories');
	}
	
	public function loginAction()
	{
	    if ($this->getAuthenticationService()->hasIdentity()) {
	        $this->redirect()->toRoute('admin_home');
	    }
	    
	    $request = $this->getRequest();
	    $viewModel = new ViewModel();
	    
	    if ($request->isPost()) {
	        $postData = $request->getPost();
	        $this->getLoginService()->processLoginForm($postData, $viewModel);
	           
	        if ($this->getAuthenticationService()->hasIdentity()) {
	            $this->redirect()->toRoute('admin_home');
	        }
	    } else {
	        $this->getLoginService()->processLoginForm(null, $viewModel);
	    }
	    
	    return $viewModel;
	}
	
	/**
	 * @return AuthenticationService 
	 */
	protected function getAuthenticationService()
	{
	    return $this->authenticationService;
	}
	
	protected function setAuthenticationService($authService)
	{
	    $this->authenticationService = $authService;
	}
	
	protected function setLoginService($loginService)
	{
	    $this->loginService = $loginService;
	}
	
	/**
	 * @return LoginService
	 */
	protected function getLoginService()
	{
	    return $this->loginService;
	}
}
