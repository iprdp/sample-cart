<?php
namespace Catalog\Service;

use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Catalog\Entity\Cart;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\Debug;

class CartService
{
    protected $objectManager;
    
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }
    
    public function getItemCount()
    {
        $cart = $this->getCart();
        
        return sizeof($cart->getProducts());
    }
    
    public function processViewCart(ViewModel $viewModel)
    {
        $products = array();
        $cart = $this->getCart();
        $productIds = array_keys($cart->getProducts());
        $productObjects = $this->getObjectManager()->getRepository('Catalog\Entity\Product')->findBy([
            'id' => $productIds,
        ]);
        foreach($productObjects as $product) {
            $products[$product->getId()] = $product;
        }
        
        $viewModel->setVariables([
            'cart' => $cart,
            'products' => $products,
        ]);
    }
    
    public function processAddToCart($postData, ViewModel $viewModel)
    {
        $product = $quantity = null;
        if (isset($postData['product_id']) && is_numeric($postData['product_id'])) {
            $product = $this->getObjectManager()->find('Catalog\Entity\Product', 1);
        }
        if (isset($postData['quantity']) && is_numeric($postData['quantity'])) {
            $quantity = intval($postData['quantity']);
        } 
        
        if (is_object($product) && is_int($quantity)) {
            $cart = $this->getCart();
            $cart->addUpdateProduct($product, $quantity);
            $this->saveCart($cart); 
            $viewModel->setVariable('success', true);
        } else {
            $viewModel->setVariable('success', false);
        }
    }
    
    protected function getCartSessionContainer() 
    {
        $cartSessionContainer = new Container('myCart');
        
        if (!isset($cartSessionContainer->init)) {
            $cartSessionContainer->init = true;
        }
        
        return $cartSessionContainer;        
    }
    
    protected function getCart()
    {
        $cartSessionContainer = $this->getCartSessionContainer();
        
        if (isset($cartSessionContainer->cartObject)) {
            $cartObject = $cartSessionContainer->cartObject;
        } else {
            $cartObject = new Cart();
        }
        
        return $cartObject;
    }
    
    protected function saveCart(Cart $cart)
    {
        $cartSessionContainer = $this->getCartSessionContainer();    
        $cartSessionContainer->cartObject = $cart;
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