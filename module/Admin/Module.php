<?php

namespace Admin;

use Zend\Mvc\Controller\ControllerManager;
use Admin\Controller\HomeController;
use Admin\Service\AuthenticationService;
use Admin\Service\LoginService;

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
	            'Admin\AuthenticationService' => function() {
	                return new AuthenticationService();
	            },
	            'Admin\LoginService' => function($serviceLocator) {
	               return new LoginService(
                       $serviceLocator->get('Admin\AuthenticationService')
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
	               
	               return new HomeController(
                       $authService, 
                       $objectManager, 
                       $loginService
                   );
	            },
            ],
	    ];
	}
}
