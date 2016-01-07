<?php

namespace Admin;

return [
	'router' => [ 
		'routes' => [ 
			'admin_home' => [
				'type' => 'segment',
				'options' => [
					'route'    => '/admin[/[index]]',
					'defaults' => [
						'controller' => 'Admin\Controller\Home',
						'action'     => 'home',
					],
				],
			],
		    'admin_login' => [
		        'type' => 'literal',
		        'options' => [
		            'route'    => '/admin/login',
		            'defaults' => [
		                'controller' => 'Admin\Controller\Home',
		                'action'     => 'login',
		            ],
		        ],
		    ],
		    'admin_categories' => [
		        'type' => 'literal',
		        'options' => [
		            'route'    => '/admin/categories',
		            'defaults' => [
		                'controller' => 'Admin\Controller\Home',
		                'action'     => 'viewCategories',
		            ],
		        ],
		    ],
		    'admin_categories' => [
		        'type' => 'literal',
		        'options' => [
		            'route'    => '/admin/products',
		            'defaults' => [
		                'controller' => 'Admin\Controller\Home',
		                'action'     => 'viewProducts',
		            ],
		        ],
		    ],
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