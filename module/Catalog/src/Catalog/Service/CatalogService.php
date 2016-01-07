<?php

namespace Catalog\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\View\Model\ViewModel;

class CatalogService
{
    protected $objectManager;
    
    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
    }
    
    public function processViewCategories($categoryId, ViewModel $viewModel)
    {
        $category = null;
        if (is_numeric($categoryId)) {
            $category = $this->getObjectManager()->find(
                'Catalog\Entity\ProductCategory', 
                $categoryId
            );
        }
        
        if (isset($category)) {
            $viewModel->setVariable('currentCategory', $category);
        } else {
            $parentCategories = $this->getObjectManager()
                ->getRepository('Catalog\Entity\ProductCategory')->findBy([
                    'parent' => null,
                ]);
            $viewModel->setVariable('parentCategories', $parentCategories);
        }
    }
    
    public function getProductCategories()
    {
        return $this->getObjectManager()
                ->getRepository('Catalog\Entity\ProductCategory')->findAll();
    }
    
    public function getProducts()
    {
        return $this->getObjectManager()
        ->getRepository('Catalog\Entity\Product')->findAll();
    }
    
    protected function setObjectManager($objectManager)
    {
        $this->objectManager = $objectManager;
    }
    
    /**
     * @return ObjectManager
     */
    protected function getObjectManager()
    {
        return $this->objectManager;         
    }
}
