<?php

namespace Catalog;

use Catalog\View\Helper\HeaderCart;

return [
	'router' => [ 
		'routes' => [ 
			'catalog_view_categories' => [
				'type' => 'segment',
				'options' => [
					'route'    => '/categories[/:c_name[/:c_id]]',
					'defaults' => [
						'controller' => 'Catalog\Controller\Catalog',
						'action'     => 'viewCategories',
					],
				],
			],          
            'catalog_product' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/product',
                    'defaults' => [
                        'controller' => 'Catalog\Controller\Catalog',
                        'action'     => 'viewProduct',
                    ],
                ],
            ],
		    'cart_view_cart' => [
		        'type' => 'segment',
		        'options' => [
		            'route' => '/cart',
		            'defaults' => [
		                'controller' => 'Catalog\Controller\Cart',
		                'action'     => 'viewCart',
		            ],
		        ],
		    ],
		],
	],
    'view_helpers' => [
        'factories' => [
            'headerCart' => function() {
                return new HeaderCart();
            },
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