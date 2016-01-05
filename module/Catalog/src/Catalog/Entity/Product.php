<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Account
 * @package Finance\Entity
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
     * @ORM\Column(name="title", type="string", length=100, unique=true, nullable=false)
     * @var string
     */
    protected $title;
    
    /**
     * @ORM\Column(name="catalog_no", type="string", length=50, unique=true, nullable=false)
     * @var string
     */
    protected $catalogNumber;
    
    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     * @var string
     */
    protected $description;
    
    /**
     * @ORM\Column(name="unit_price", type="float", precision=13, scale=3, nullable=false)
     * @var float
     */
    protected $unitPrice;
    
    /**
     * @ORM\Column(name="display_img", type="string", length=30, unique=true, nullable=false)
     * @var string
     */
    protected $displayImage;
    
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
    
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }
    
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }
    
    public function getDisplayImage()
    {
        return $this->displayImage;
    }
    
    public function setDisplayImage($displayImage)
    {
        $this->displayImage = $displayImage;
    }
}