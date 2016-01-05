<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Session\Container;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        // initialize Global Static Db Adapter
        if ($e->getApplication()->getServiceManager()->has('Zend\Db\Adapter\Adapter')) {
        	$adapter = $e->getApplication()->getServiceManager()->get('Zend\Db\Adapter\Adapter');
        	GlobalAdapterFeature::setStaticAdapter($adapter);
        }
        
        // session
        $session = $e->getApplication()
        ->getServiceManager()
        ->get('Application\SessionManager');
        $session->start();
        
        $container = new Container('initialized');
        if (!isset($container->init)) {
        	$session->regenerateId(true);
        	$container->init = 1;
        }
        
        Container::setDefaultManager($session);
    }

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
}
