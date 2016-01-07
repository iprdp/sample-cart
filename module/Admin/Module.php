<?php

namespace Admin;

use Zend\Mvc\Controller\ControllerManager;
use Admin\Controller\HomeController;
use Admin\Service\AuthenticationService;
use Admin\Service\LoginService;
use Admin\Controller\CatalogProductController;
use Admin\Service\AdminCatalogService;

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
	        'aliases' => [
	            'Zend\Authentication\AuthenticationService' 
	                   => 'Admin\AuthenticationService',
	        ],
	        'factories' => [
	            'Admin\AuthenticationService' => function() {
	                return new AuthenticationService();
	            },
	            'Admin\LoginService' => function($serviceLocator) {
	               return new LoginService(
                       $serviceLocator->get('Admin\AuthenticationService')
                   );
	            },
	            'Admin\AdminCatalogService' => function($serviceLocator) {
	                return new AdminCatalogService(
                        $serviceLocator->get('Catalog\CatalogService'),
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
	            'Admin\Controller\Home' => function(ControllerManager $controllerManager) {
	               $authService = $controllerManager->getServiceLocator()->get('Admin\AuthenticationService');
	               $loginService = $controllerManager->getServiceLocator()->get('Admin\LoginService');
	               
	               return new HomeController(
                       $authService, 
                       $loginService
                   );
	            },
	            'Admin\Controller\CatalogProduct' => function(ControllerManager $controllerManager) {
	            $authService = $controllerManager->getServiceLocator()->get('Admin\AuthenticationService');
	            $adminCatalogService = $controllerManager->getServiceLocator()->get('Admin\AdminCatalogService');
	            
	            return new CatalogProductController(
	                    $authService,
	                    $adminCatalogService
                    );
	            },
            ],
	    ];
	}
}
