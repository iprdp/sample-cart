<?php

namespace Admin\Service;

use Catalog\Service\CatalogService;
use Zend\View\Model\ViewModel;

class HomeService
{
    protected $catalogService;
    
    public function __construct(CatalogService $catalogService)
    {
        $this->setCatalogService($catalogService);
    }
    
    public function loadViewCategories(ViewModel $viewModel)
    {
        $categories = $this->getCatalogService()->getProductCategories();
        
        $viewModel->setVariables([
            'categories' => $categories,
        ]);
    }
    
    public function loadViewProducts(ViewModel $viewModel)
    {
        $products = $this->getCatalogService()->getProducts();
    
        $viewModel->setVariables([
            'products' => $categories,
        ]);
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
