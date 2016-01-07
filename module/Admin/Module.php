<?php

namespace Admin;

use Zend\Mvc\Controller\ControllerManager;
use Admin\Controller\HomeController;
use Admin\Service\AuthenticationService;
use Admin\Service\LoginService;
use Admin\Service\HomeService;

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
	            'Admin\HomeService' => function($serviceLocator) {
	                return new HomeService(
                        $serviceLocator->get('Catalog\CatalogService')
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
	               $objectManager = $controllerManager->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	               $loginService = $controllerManager->getServiceLocator()->get('Admin\LoginService');
	               $homeService = $controllerManager->getServiceLocator()->get('Admin\HomeService');
	               
	               return new HomeController(
                       $authService, 
                       $objectManager, 
                       $loginService,
                       $homeService
                   );
	            },
            ],
	    ];
	}
}
