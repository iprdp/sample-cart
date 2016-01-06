<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Doctrine\Common\Persistence\ObjectManager;

class HomeController extends AbstractActionController 
{
    protected $authenticationService;
    
    protected $objectManager;
    
    public function __construct(
        AuthenticationService $authService, 
        ObjectManager $objectManager
    ) {
        $this->setAuthenticationService($authService);
        $this->setObjectManager($objectManager);
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
}
