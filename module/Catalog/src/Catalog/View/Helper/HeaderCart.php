<?php

namespace Catalog\View\Helper;

use Zend\View\Helper\AbstractHelper;

class HeaderCart extends AbstractHelper
{
	public function __invoke()
	{
		return $this->getView()->render('catalog/catalog/header-cart.phtml');
	}
}
