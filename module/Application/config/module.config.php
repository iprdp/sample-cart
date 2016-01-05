<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Catalog\Controller\ProductCategory',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
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
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => Controller\IndexController::class
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
