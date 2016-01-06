<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ProductCategory
 * @package Catalog\Entity
 * @ORM\Entity
 * @ORM\Table(name="product_categories")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class ProductCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id",type="integer" , nullable=false)
     * @var integer
     */
    private $id;
    
    /**
     * @ORM\Column(name="title", type="string", length=100, unique=true, 
     *      nullable=false)
     * @var string
     */
    protected $title;
    
    /**
     * @ORM\ManyToOne(targetEntity="Catalog\Entity\ProductCategory", 
     *      inversedBy="children", cascade={"refresh"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", 
     *      nullable=true)
     * @var ProductCategory
     */
    protected $parent;
    
    /**
     * @ORM\OneToMany(targetEntity="Catalog\Entity\ProductCategory", 
     *      mappedBy="parent", orphanRemoval=true, 
     *      cascade={"persist", "remove", "refresh"})
     * @var ArrayCollection
     */
    protected $children;
    
    /**
     * @ORM\OneToMany(targetEntity="Catalog\Entity\Product", 
     *      mappedBy="primaryCategory", orphanRemoval=true, 
     *      cascade={"persist", "remove", "refresh"})
     * @var ArrayCollection
     */
    protected $products;
    
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent(ProductCategory $parent=null)
    {
        $this->parent = $parent;
    }
    
    public function getChildren()
    {
        return $this->children;
    }
    
    public function setChildren($children)
    {
        $this->children = $children;
    }
    
    public function addChildren($children)
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }
    }
    
    public function addChild(ProductCategory $category)
    {
        if (!$this->children->contains($category)) {
            $this->children->add($category);
        }
        $category->setParent($this);
    }
    
    public function removeChildren($children)
    {
        foreach ($children as $child) {
            $this->removeChild($child);
        }
    }
    
    public function removeChild(ProductCategory $category)
    {
        if ($this->children->contains($category)) {
            $this->children->removeElement($category);
        }
        $category->setParent(null);
    }
    
    public function getProducts()
    {
        return $this->products;
    }
    
    public function setProducts($products)
    {
        $this->products = $products;
    }
    
    public function addProducts($products)
    {
        foreach ($products as $product) {
            $this->addProduct($product);
        }
    }
    
    public function addProduct(Product $product)
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
        $product->setCategory($this);
    }
    
    public function removeProducts($products)
    {
        foreach ($products as $product) {
            $this->removeProduct($product);
        }
    }
    
    public function removeProduct(Product $product)
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }
        $product->setCategory(null);
    }
}
