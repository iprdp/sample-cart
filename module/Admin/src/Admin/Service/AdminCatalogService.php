<?php

namespace Admin\Service;

use Catalog\Service\CatalogService;
use Zend\View\Model\ViewModel;
use Admin\Form\CatalogProduct as CatalogProductForm;
use Doctrine\Common\Persistence\ObjectManager;

class AdminCatalogService
{
    protected $catalogService;
    
    protected $objectManager;
    
    public function __construct(
        CatalogService $catalogService,
        ObjectManager $objectManager
    ) {
        $this->setCatalogService($catalogService);
        $this->setObjectManager($objectManager);
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
            'products' => $products,
        ]);
    }
    
    public function processNewEditProduct(
        $productId=null, 
        $data=array(), 
        ViewModel $viewModel
    ) {
        $product = null;
        $form = new CatalogProductForm($this->getObjectManager());
        
        if (null != $productId) {
            $product = $this->getObjectManager()->find('Catalog\Entity\Product', $productId);
        }
        
        if (!empty($data)) {
            $form->setData($data);
            if ($form->isValid()) {
                $product = $form->getObject();
            }
        } elseif (null != $product) {
            $form->bind($product);
        }
        
        $viewModel->setVariables([
            'form' => $form,
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
    
    protected function setObjectManager($objectManager)
    {
        $this->objectManager = $objectManager;
    }
    
    protected function getObjectManager()
    {
        return $this->objectManager;
    }
}
