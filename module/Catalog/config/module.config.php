<?php

namespace Catalog;

return [
	'router' => [ 
		'routes' => [ 
			'catalog_index' => [
				'type' => 'literal',
				'options' => [
					'route'    => '/index',
					'defaults' => [
						'controller' => 'Catalog\Controller\ProductCategory',
						'action'     => 'index',
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
        'template_map' => array(
            'catalog/product-category/index' 
                => __DIR__ . '/../view/catalog/product-category/index.phtml',
        ),
		'template_path_stack' => [
            __DIR__ . '/../view',
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