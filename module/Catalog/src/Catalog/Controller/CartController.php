<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Catalog\Service\CatalogService;
use Catalog\Service\CartService;

class CartController extends AbstractActionController 
{
    protected $catalogService;
    
    public function __construct(
        CatalogService $catalogService,
        CartService $cartService
    ) {
        $this->setCatalogService($catalogService);
        $this->setCartService($cartService);
    }
    
	public function viewCartAction() 
	{
	    $viewModel = new ViewModel();
	    $request = $this->getRequest();
	    
	    $this->getCartService()->processViewCart($viewModel);
	    
	    return $viewModel;
	}
	
	public function addToCartAction()
	{
	    $viewModel = $this->acceptableViewModelSelector($this->getViewModelSelectorCriteria());
	    $request = $this->getRequest();
	     
	    if ($request->isPost()) {
	        $postData = $request->getPost()->toArray();
	        $this->getCartService()->processAddToCart($postData, $viewModel);
	    }
	     
	    return $viewModel;
	}
	
	public function viewProductAction()
	{
	    return new ViewModel();
	}
	
	protected function setCatalogService($catalogService)
	{
	    $this->catalogService = $catalogService;
	}
	
	protected function getCatalogService()
	{
	    return $this->catalogService;
	}
	
	protected function setCartService($cartService)
	{
	    $this->cartService = $cartService;
	}
	
	protected function getCartService()
	{
	    return $this->cartService;
	}
	
	/**
	 * @return array
	 */
	protected function getViewModelSelectorCriteria()
	{
	    return array(
	        'Zend\View\Model\ViewModel' => array(
	            'text/html',
	        ),
	        'Zend\View\Model\JsonModel' => array(
	            'application/json',
	        )
	    );
	}
}
