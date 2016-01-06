<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Session\Container;
use Doctrine\Common\Util\Debug;

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
        
        $this->bootstrapGlobalMvcEventErrorListener($e);
        
        $this->bootstrapSetLayouts($e);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'abstract_factories' => array(
                'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
                'Zend\Log\LoggerAbstractServiceFactory',
            ),
            'factories' => array(
                'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',

                'Application\SessionManager' => function ($sm) {
                    $config = $sm->get('Config');
                    if (isset($config['session'])) {
                        $session = $config['session'];
                        $sessionConfig = null;
                        if (isset($session)) {
                            $sessionConfig = new \Zend\Session\Config\SessionConfig();
                            $sessionConfig->setOptions($session);
                        }
                        $storagePath = '';
                        if (isset($config['app_base_dir'])) {
                            $storagePath = $config['app_base_dir'] . DIRECTORY_SEPARATOR;
                        }
                        $storagePath .= '/data/sessions/cache';
                        $fileCacheStorage = new \Zend\Cache\Storage\Adapter\FileSystem([
                                        'cache_dir' => $storagePath,
                        ]);
                        $sessionSaveHandler = new \Zend\Session\SaveHandler\Cache($fileCacheStorage);
    
                        $sessionManager = new \Zend\Session\SessionManager(
                                $sessionConfig,
                                null,
                                $sessionSaveHandler
                                );
    
                        if (isset($session['validators'])) {
                            $chain = $sessionManager->getValidatorChain();
                            foreach ($session['validators'] as $validator) {
                                $validator = new $validator();
                                $chain->attach('session.validate', array($validator, 'isValid'));
                            }
                        }
                    } else {
                        $sessionManager = new \Zend\Session\SessionManager();
                    }
                    \Zend\Session\Container::setDefaultManager($sessionManager);
    
                    return $sessionManager;
                },
            ),
        );
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
    
    public function bootstrapGlobalMvcEventErrorListener(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
    
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function(MvcEvent $event) {
            $exception = $event->getParam('exception');
    
            if (isset($exception)) {
                Debug::dump($exception, 10);
            }
    
        }, 100);
    }
    
    public function bootstrapSetLayouts(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()->attach(
            'Zend\Mvc\Controller\AbstractActionController',
            'dispatch',
            function(MvcEvent $e) {
                $controller = $e->getTarget();
                $controllerClass = get_class($controller);
                $moduleNamespace = substr(
                        $controllerClass,
                        0,
                        strpos($controllerClass, '\\')
                        );
                $layout = 'layout/layout';
                // Module specific
                switch ($moduleNamespace) {
                    case 'Admin':
                        $layout = 'layout/admin';
                }

                $controller->layout($layout);
            }
        );
    }
}
