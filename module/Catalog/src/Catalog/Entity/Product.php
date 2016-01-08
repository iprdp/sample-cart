<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Catalog\Entity\ProductCategory;

/**
 * Class Product
 * @package Catalog\Entity
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id",type="integer" , nullable=false)
     * @var integer
     */
    private $id;
    
    /**
     * @ORM\Column(name="title", type="string", length=200, unique=true, 
     *      nullable=false)
     * @var string
     */
    protected $title;
    
    /**
     * @ORM\Column(name="make", type="string", length=100, unique=true, 
     *      nullable=false)
     * @var string
     */
    protected $make;
    
    /**
     * @ORM\Column(name="model_no", type="string", length=50, unique=true, 
     *      nullable=false)
     * @var string
     */
    protected $modelNumber;
    
    /**
     * @ORM\Column(name="catalog_no", type="string", length=50, unique=true, 
     *      nullable=false)
     * @var string
     */
    protected $catalogNumber;
    
    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     * @var string
     */
    protected $description;
    
    /**
     * @ORM\Column(name="features", type="text", nullable=true)
     * @var string
     */
    protected $features;
    
    /**
     * @ORM\Column(name="unit_price", type="float", precision=13, scale=3, 
     *      nullable=false)
     * @var float
     */
    protected $unitPrice;
    
    /**
     * @ORM\Column(name="currency_code", type="string", length=10, 
     *      nullable=false)
     * @var string
     */
    protected $currencyCode;
    
    /**
     * @ORM\Column(name="display_img", type="string", length=30, unique=true, 
     *      nullable=false)
     * @var string
     */
    protected $displayImage;
    
    /**
     * @ORM\ManyToOne(targetEntity="Catalog\Entity\ProductCategory", 
     *      inversedBy="products", cascade={"refresh"})
     * @var ProductCategory
     */
    protected $primaryCategory;
    
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
    
    public function getMake()
    {
        return $this->make;
    }
    
    public function setMake($make)
    {
        $this->make = $make;
    }
    
    public function getModelNumber()
    {
        return $this->modelNumber;
    }
    
    public function setModelNumber($modelNumber)
    {
        $this->modelNumber = $modelNumber;
    }
    
    public function getCatalogNumber()
    {
        return $this->catalogNumber;
    }
    
    public function setCatalogNumber($catalogNumber)
    {
        $this->catalogNumber = $catalogNumber;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function getFeatures()
    {
        return $this->features;
    }
    
    public function setFeatures($features)
    {
        $this->features = $features;
    }
    
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }
    
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }
    
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }
    
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }
    
    public function getDisplayImage()
    {
        return $this->displayImage;
    }
    
    public function setDisplayImage($displayImage)
    {
        $this->displayImage = $displayImage;
    }
    
    public function getPrimaryCategory()
    {
        return $this->primaryCategory;
    }
    
    public function setPrimaryCategory(ProductCategory $category=null)
    {
        $this->primaryCategory = $category;
    }
}
