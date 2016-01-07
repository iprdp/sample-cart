<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\AuthenticationService;
use Zend\View\Model\ViewModel;
use Admin\Service\AdminCatalogService;

class CatalogProductController extends AbstractActionController 
{
    protected $authenticationService;
    
    protected $objectManager;
    
    protected $adminCatalogService;
    
    public function __construct(
        AuthenticationService $authService, 
        AdminCatalogService $adminCatalogService
    ) {
        $this->setAuthenticationService($authService);
        $this->setAdminCatalogService($adminCatalogService);
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
	     
	    $this->getAdminCatalogService()->loadViewCategories($viewModel);
	     
	    return $viewModel;
	}
	
	public function viewProductsAction()
	{
	    if (!$this->getAuthenticationService()->hasIdentity()) {
            $this->redirect()->toRoute('admin_login');
	    }
	
	    $request = $this->getRequest();
	    $viewModel = new ViewModel();
	
	    $this->getAdminCatalogService()->loadViewProducts($viewModel);
	
	    return $viewModel;
	}
	
	public function editProductAction()
	{
	    if (!$this->getAuthenticationService()->hasIdentity()) {
	        $this->redirect()->toRoute('admin_login');
	    }
	    
	    $request = $this->getRequest();
	    $productId = $this->params()->fromRoute('id');
	    $viewModel = new ViewModel();
	    
	    if ($request->isPost()) {
	        $postData = $request->getPost()->toArray();
	        $this->getAdminCatalogService()->processNewEditProduct(
                $productId, 
                $postData, 
                $viewModel
            );
	    } else {
	        $this->getAdminCatalogService()->processNewEditProduct(
                $productId,
                null,
                $viewModel
            );
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
	
	/**
	 * @return AdminCatalogService
	 */
	protected function getAdminCatalogService()
	{
	    return $this->adminCatalogService;
	}
	
	protected function setAdminCatalogService($catalogService)
	{
	    $this->adminCatalogService = $catalogService;
	}
}
