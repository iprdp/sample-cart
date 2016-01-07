<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Catalog\Service\CatalogService;

class CatalogController extends AbstractActionController 
{
    protected $catalogService;
    
    public function __construct(CatalogService $catalogService) 
    {
        $this->setCatalogService($catalogService);
    }
    
	public function viewCategoriesAction() 
	{
	    $viewModel = new ViewModel();
	    $request = $this->getRequest();
	    $categoryId = $this->params()->fromRoute('c_id');
	    
	    $this->getCatalogService()->processViewCategories($categoryId, $viewModel);
	    
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
}
