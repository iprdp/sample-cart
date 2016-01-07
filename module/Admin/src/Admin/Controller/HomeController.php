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
    
    protected $objectManager;
    
    protected $loginService;
    
    public function __construct(
        AuthenticationService $authService, 
        ObjectManager $objectManager,
        LoginService $loginService
    ) {
        $this->setAuthenticationService($authService);
        $this->setObjectManager($objectManager);
        $this->setLoginService($loginService);
    }
    
	public function homeAction() 
	{
	    if (!$this->getAuthenticationService()->hasIdentity()) {
	        $this->redirect()->toRoute('admin_login');
	    }
	    
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
	        $this->getLoginService()->doLogin($postData);
	           
	        if ($this->getAuthenticationService()->hasIdentity()) {
	            $this->redirect()->toRoute('admin_home');
	        }
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
	
	protected function setObjectManager($objectManager)
	{
	    $this->objectManager = $objectManager;
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
