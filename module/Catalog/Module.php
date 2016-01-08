<?php

namespace Catalog;

use Catalog\Service\CatalogService;
use Catalog\Controller\CatalogController;
use Zend\Mvc\Controller\ControllerManager;
use Catalog\Controller\CartController;
use Catalog\Service\CartService;

class Module 
{
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getAutoloaderConfig()
	{
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		              __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
			),
		);
	}
	
	public function getServiceConfig()
	{
	    return [
	        'factories' => [
	            'Catalog\CatalogService' => function($serviceLocator) {
	                return new CatalogService(
	                        $serviceLocator->get('doctrine.entitymanager.orm_default')
                        );
	            },
	            'Catalog\CartService' => function($serviceLocator) {
                    return new CartService(
                        $serviceLocator->get('doctrine.entitymanager.orm_default')
                    );
	            },
	        ],
	    ];
	}
	
	public function getControllerConfig()
	{
	    return [
    	    'factories' => [
    	        'Catalog\Controller\Catalog' => function(ControllerManager $controllerManager) {
    	            return new CatalogController(
	                    $controllerManager->getServiceLocator()->get('Catalog\CatalogService')
                    );
    	        },
    	        'Catalog\Controller\Cart' => function(ControllerManager $controllerManager) {
    	        return new CartController(
	                $controllerManager->getServiceLocator()->get('Catalog\CatalogService'),
	                $controllerManager->getServiceLocator()->get('Catalog\CartService')
                );
    	        },
    	    ],
	    ];
	}
}