<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Doctrine\Common\Persistence\ObjectManager;
use Admin\Service\LoginService;
use Admin\Service\HomeService as AdminHomeService;
use Admin\Service\HomeService;

class HomeController extends AbstractActionController 
{
    protected $authenticationService;
    
    protected $objectManager;
    
    protected $loginService;
    
    protected $adminHomeService;
    
    public function __construct(
        AuthenticationService $authService, 
        ObjectManager $objectManager,
        LoginService $loginService,
        HomeService $adminHomeService
    ) {
        $this->setAuthenticationService($authService);
        $this->setObjectManager($objectManager);
        $this->setLoginService($loginService);
        $this->setAdminHomeService($adminHomeService);
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
	
	public function viewCategoriesAction()
	{
	    if (!$this->getAuthenticationService()->hasIdentity()) {
	        // @TODO use a Controller guarding tool to automatically check
	        // roles and controller actions
	        // @TODO Save original request location to redirect after login 
	        $this->redirect()->toRoute('admin_login');
	    }
	     
	    $request = $this->getRequest();
	    $viewModel = new ViewModel();
	     
	    $this->getAdminHomeService()->loadViewCategories($viewModel);
	     
	    return $viewModel;
	}
	
	public function viewProductsAction()
	{
	    if (!$this->getAuthenticationService()->hasIdentity()) {
	        // @TODO use a Controller guarding tool to automatically check
	        // roles and controller actions
	        // @TODO Save original request location to redirect after login
	        $this->redirect()->toRoute('admin_login');
	    }
	
	    $request = $this->getRequest();
	    $viewModel = new ViewModel();
	
	    $this->getAdminHomeService()->loadViewProducts($viewModel);
	
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
	
	/**
	 * @return AdminHomeService
	 */
	protected function getAdminHomeService()
	{
	    return $this->adminHomeService;
	}
	
	protected function setAdminHomeService($homeService)
	{
	    $this->adminHomeService = $homeService;
	}
}
