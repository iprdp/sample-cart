<?php

namespace Catalog;

return [
	'router' => [ 
		'routes' => [ 
			'catalog_category' => [
				'type' => 'literal',
				'options' => [
					'route'    => '/category',
					'defaults' => [
						'controller' => 'Catalog\Controller\ProductCategory',
						'action'     => 'viewCategory',
					],
				],
			],          
            'catalog_product' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/product',
                    'defaults' => [
                        'controller' => 'Catalog\Controller\ProductCategory',
                        'action'     => 'viewProduct',
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
			'Catalog\Controller\ProductCategory' => 
		                'Catalog\Controller\ProductCategoryController',
		],
	],
	'view_manager' => [
        'template_path_stack' => [
            'catalog' => __DIR__ . '/../view',
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