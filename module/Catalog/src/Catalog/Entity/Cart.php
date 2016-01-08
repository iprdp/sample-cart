<?php

namespace Catalog\Entity;

class Cart 
{
    /**
     * @var array
     */
    protected $products;
    
    public function __construct()
    {
        $this->products = array();
    }
    
    public function getProducts()
    {
        return $this->products;
    }
    
    public function setProducts($products)
    {
        $this->products = $products;
    }
    
    public function addUpdateProduct(Product $product, $quantity)
    {
        if (!is_int($quantity)) {
            throw new \DomainException(sprintf(
                    '%s expects param 2 to be a valid int',
                    __METHOD__
                ));
        }
        
        if (!isset($this->products[$product->getId()])) {
            $this->products[$product->getId()] = 0;
        }
        
        $this->products[$product->getId()] += $quantity;
    }
     
    public function removeProduct(Product $product)
    {
        if (isset($this->products[$product->getId()])) {
            unset($this->products[$product->getId()]);
        }
    }
}
