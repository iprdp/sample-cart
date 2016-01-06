<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db' => array(
		'driver'            => 'Pdo_Mysql',
		'dsn'               => 'mysql:dbname=sample-cart;host=localhost',
		'driver_options'    => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
			PDO::MYSQL_ATTR_LOCAL_INFILE => true,
		),
	),
	'doctrine' => array(
		'connection' => array(
			'orm_default' => array(
				'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
				'params' => array(
					'host'     	=> 'localhost',
					'port'     	=> '3306',
					'dbname'   	=> 'sample-cart',
					'driverOptions' => array(
						PDO::MYSQL_ATTR_LOCAL_INFILE => true,
					),
				),
			),
		),
		'configuration' => array(
			'orm_default' => array(
				'generate_proxies'  => true,
				'metadata_cache'    => 'array',
				'query_cache'       => 'array',
				'result_cache'      => 'array',
				'proxy_dir'         => './data/DoctrineORMModule/Proxy',
				'proxy_namespace'   => 'DoctrineORMModule\Proxy',
			),
		),
	),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'view_manager' => array(
        'display_exceptions'        => false,
        'exception_template'        => 'error/index',
        'display_not_found_reason'  => true,
        'not_found_template'        => 'error/404',
    ),
	'host' => array(
		'server_name'   => 'sample-cart.dev',
		'protocol'      => 'http',
	),
);
