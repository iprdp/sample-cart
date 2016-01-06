<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProductCategoryController extends AbstractActionController 
{
	public function viewCategoryAction() 
	{
	    return new ViewModel();
	}
	
	public function viewProductAction()
	{
	    return new ViewModel();
	}
}