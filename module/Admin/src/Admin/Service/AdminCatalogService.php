<?php

namespace Admin\Service;

use Catalog\Service\CatalogService;
use Zend\View\Model\ViewModel;
use Admin\Form\CatalogProduct as CatalogProductForm;
use Doctrine\Common\Persistence\ObjectManager;
use Catalog\Entity\Product;

class AdminCatalogService
{
    protected $catalogService;
    
    protected $objectManager;
    
    protected $applicationConfig;
    
    public function __construct(
        CatalogService $catalogService,
        ObjectManager $objectManager,
        array $applicationConfig
    ) {
        $this->setCatalogService($catalogService);
        $this->setObjectManager($objectManager);
        $this->applicationConfig = $applicationConfig;
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
    
    public function getCatalogProductForm()
    {
        return new CatalogProductForm($this->getObjectManager());
    }
    
    public function saveProduct(Product $product)
    {
        $fileUploadSuccess = true;
        $fileData = $product->getDisplayImage();
        
        if (is_array($fileData) && !empty($fileData)) {
            $appBaseDir = $this->applicationConfig['app_base_dir'];
            $tmpFilePath = $appBaseDir . DIRECTORY_SEPARATOR . $fileData['tmp_name'];
            $tmpFileName = pathinfo($tmpFilePath, PATHINFO_BASENAME);
            
            if (file_exists($tmpFilePath)) {
                $fileName = $fileData['name'];
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                if (is_string($extension) && (strlen($extension) > 0)) {
                    $newFileName = $tmpFileName . '.' . $extension;
                }
                $newFilePath = $productImagePath = '/data/uploaded-files/products/images/' . $newFileName;
                $newFilePath = $appBaseDir . $newFilePath;
                
                
                $fileUploadSuccess = $this->moveFile($tmpFilePath, $newFilePath);
                if ($fileUploadSuccess) {
                    // @TODO should delete the old image file
                    $product->setDisplayImage($productImagePath);
                } else {
                    // @TODO App right now is not showing nice error messages/pages
                    // This should be caught, logged and user should see a 
                    // better error/failure message
                    throw new \DomainException('File upload failed');
                }
            }
        }
        
        $this->getObjectManager()->persist($product);
        $this->getObjectManager()->flush();
    }
    
    protected function moveFile($oldFilePath, $newFilePath)
    {
        if (! file_exists($oldFilePath)) {
            throw new \DomainException(sprintf(
                '%s expects a valid filepath, %s provided does not exists or is not readable',
                __METHOD__,
                $oldFilePath
            ));
        }
    
        if (! is_writable(dirname($newFilePath))) {
            throw new \DomainException(sprintf(
                'Destionation directory, %s,  is not writable!',
                dirname($newFilePath)
            ));
        }
    
        return rename($oldFilePath, $newFilePath);
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
