<?php

namespace Admin;

return [
	'router' => [ 
		'routes' => [ 
			'catalog_category' => [
				'type' => 'literal',
				'options' => [
					'route'    => '/admin[/[index]]',
					'defaults' => [
						'controller' => 'Admin\Controller\Home',
						'action'     => 'home',
					],
				],
			],          
		],
	],
	'service_manager' => [
		'factories' => [
		],
	],
	'controllers' => [
		'invokables' => [
			'Admin\Controller\Login' => 
		                'Admin\Controller\LoginController',
		],
	],
	'view_manager' => [
        'template_path_stack' => [
            'admin' => __DIR__ . '/../view',
		],
	],
	'doctrine' => [
		'driver' => [
			__NAMESPACE__ . '_driver' => [
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'],
			],
			'orm_default' => [
				'drivers' => [
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
				],
			],
		],
	],
];