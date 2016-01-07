<?php

namespace Catalog;

use Catalog\Service\CatalogService;
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
	        ],
	    ];
	}
}