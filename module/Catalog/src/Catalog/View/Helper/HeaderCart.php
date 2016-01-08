<?php

namespace Catalog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HeaderCart extends AbstractHelper implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;
    
	public function __invoke()
	{
		return $this->getView()->render('catalog/catalog/header-cart.phtml', [
		    'itemCount' => $this->getCartService()->getItemCount(), 
		]);
	}
	
	protected function getCartService()
	{
	    return $this->getServiceLocator()->get('Catalog\CartService');
	}
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
	    $this->serviceLocator = $serviceLocator->getServiceLocator();
	}
	
	public function getServiceLocator()
	{
	    return $this->serviceLocator;
	}
}
