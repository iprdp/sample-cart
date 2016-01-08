<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Service\AuthenticationService;
use Zend\View\Model\ViewModel;
use Admin\Service\AdminCatalogService;
use Doctrine\Common\Persistence\ObjectManager;

class CatalogProductController extends AbstractActionController 
{
    protected $authenticationService;
    
    protected $objectManager;
    
    protected $adminCatalogService;
    
    public function __construct(
        AuthenticationService $authService, 
        AdminCatalogService $adminCatalogService,
        ObjectManager $objectManager
    ) {
        $this->setAuthenticationService($authService);
        $this->setAdminCatalogService($adminCatalogService);
        $this->setObjectManager($objectManager);
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
	    $viewModel = new ViewModel();
	    $product = null;
	    $productId = $this->params()->fromRoute('id');
	    $form = $this->getAdminCatalogService()->getCatalogProductForm(); 
	    
	    if (null != $productId) {
	        $product = $this->getObjectManager()->find('Catalog\Entity\Product', $productId);
	    }
	    
	    $fprg = $this->fileprg(
            $form,
            $this->url()->fromRoute('admin_product_edit', ['id'=>$productId]),
            true
        );
	    
	    if ($fprg instanceof \Zend\Http\PhpEnvironment\Response) {
	        return $fprg;
	    } elseif ($fprg === false) {
	        $form->bind($product);
	        $viewModel->setVariable('form', $form);
	        return $viewModel;
	    }
	    
	    if ($form->isValid()) {
	        $product = $form->getObject();
	        $this->getAdminCatalogService()->saveProduct($product);
	        $viewModel->setVariable('success', true);
	    } else {
	        $viewModel->setVariable('success', false);   
	    }
	    $viewModel->setVariable('form', $form);
	    
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
	
	protected function setObjectManager($objectManager)
	{
	    $this->objectManager = $objectManager;
	}
	
	protected function getObjectManager()
	{
	    return $this->objectManager;
	}
}
