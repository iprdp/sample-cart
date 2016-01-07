<?php

namespace Catalog\Service;

use Doctrine\Common\Persistence\ObjectManager;

class CatalogService
{
    protected $objectManager;
    
    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
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
