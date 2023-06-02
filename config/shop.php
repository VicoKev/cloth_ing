<?php

$routes = [];
$prefix = config( 'app.shop_multilocale' ) ? '{locale}/' : '';

if( config( 'app.shop_multishop' ) ) {
	$routes = ['routes' => [
		'admin' => ['prefix' => $prefix . 'admin', 'middleware' => ['web', 'auth', 'verified']],
		'jqadm' => ['prefix' => 'admin/{site}/jqadm', 'middleware' => ['web', 'auth', 'verified']],
		'jsonadm' => ['prefix' => 'admin/{site}/jsonadm', 'middleware' => ['web', 'auth', 'verified']],
		'jsonapi' => ['prefix' => '{site}/jsonapi', 'middleware' => ['web', 'api']],
		'account' => ['prefix' => $prefix . '{site}/profile', 'middleware' => ['web', 'auth', 'verified']],
		'default' => ['prefix' => $prefix . '{site}/shop', 'middleware' => ['web']],
		'supplier' => ['prefix' => $prefix . '{site}/s', 'middleware' => ['web']],
		'page' => ['prefix' => $prefix . '{site}/p', 'middleware' => ['web']],
		'home' => ['prefix' => $prefix . '{site}', 'middleware' => ['web']],
		'update' => ['prefix' => '{site}'],
	] ];
}


return $routes + [

	'apc_enabled' => false, // enable for maximum performance if APCu is available
	'apc_prefix' => 'aimeos:', // prefix for caching config and translation in APCu
	'num_formatter' => 'Locale', // locale based number formatter (alternative: "Standard")
	'pcntl_max' => 4, // maximum number of parallel command line processes when starting jobs
	'version' => env( 'APP_VERSION', 1 ), // shop CSS/JS file version

	'routes' => [
		// Docs: https://aimeos.org/docs/latest/laravel/extend/#custom-routes
		// Multi-sites: https://aimeos.org/docs/latest/laravel/customize/#multiple-shops
		'admin' => ['prefix' => 'admin', 'middleware' => ['web']],
		'jqadm' => ['prefix' => 'admin/{site}/jqadm', 'middleware' => ['web', 'auth']],
		'jsonadm' => ['prefix' => 'admin/{site}/jsonadm', 'middleware' => ['web', 'auth']],
		'jsonapi' => ['prefix' => 'jsonapi', 'middleware' => ['web', 'api']],
		'account' => ['prefix' => $prefix . 'profile', 'middleware' => ['web', 'auth']],
		'default' => ['prefix' => $prefix . 'shop', 'middleware' => ['web']],
		'supplier' => ['prefix' => $prefix . 's', 'middleware' => ['web']],
		'page' => ['prefix' => $prefix . 'p', 'middleware' => ['web']],
		'home' => ['prefix' => $prefix, 'middleware' => ['web']],
		'update' => [],
	],

	'page' => [
		// Docs: https://aimeos.org/docs/latest/laravel/extend/#adapt-pages
		'account-index' => [ 'locale/select', 'basket/mini','catalog/tree','catalog/search','account/profile','account/review','account/subscription','account/basket','account/history','account/favorite','account/watch','catalog/session' ],
		'basket-index' => [ 'locale/select', 'catalog/tree','catalog/search','basket/standard','basket/bulk','basket/related' ],
		'catalog-count' => [ 'catalog/count' ],
		'catalog-detail' => [ 'locale/select', 'basket/mini','catalog/tree','catalog/search','catalog/stage','catalog/detail','catalog/session' ],
		'catalog-home' => [ 'locale/select','basket/mini','catalog/tree','catalog/search','catalog/home', 'cms/page' ],
		'catalog-list' => [ 'locale/select','basket/mini','catalog/filter','catalog/tree','catalog/search','catalog/price','catalog/supplier','catalog/attribute','catalog/session','catalog/stage','catalog/lists' ],
		'catalog-session' => [ 'locale/select','basket/mini','catalog/tree','catalog/search','catalog/session' ],
		'catalog-stock' => [ 'catalog/stock' ],
		'catalog-suggest' => [ 'catalog/suggest' ],
		'catalog-tree' => [ 'locale/select','basket/mini','catalog/filter','catalog/tree','catalog/search','catalog/price','catalog/supplier','catalog/attribute','catalog/session','catalog/stage','catalog/lists' ],
		'checkout-confirm' => [ 'catalog/tree','catalog/search','checkout/confirm' ],
		'checkout-index' => [ 'locale/select', 'catalog/tree','catalog/search','checkout/standard' ],
		'checkout-update' => [ 'checkout/update' ],
		'supplier-detail' => [ 'locale/select','basket/mini','catalog/tree','catalog/search','supplier/detail','catalog/lists'],
		'cms' => [ 'basket/mini','catalog/tree','cms/page' ],
	],

	'resource' => [
		'db' => [
			'adapter' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.driver', 'mysql' ),
			'host' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.host', '127.0.0.1' ),
			'port' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.port', '3306' ),
			'socket' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.unix_socket', '' ),
			'database' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.database', 'forge' ),
			'username' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.username', 'forge' ),
			'password' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.password', '' ),
			'stmt' => config( 'database.default', 'mysql' ) === 'mysql' ? ["SET SESSION sort_buffer_size=2097144; SET NAMES 'utf8mb4'; SET SESSION sql_mode='ANSI'"] : [],
			'limit' => 3, // maximum number of concurrent database connections
			'defaultTableOptions' => [
				'charset' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.charset' ),
				'collate' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.collation' ),
			],
			'driverOptions' => config( 'database.connections.' . config( 'database.default', 'mysql' ) . '.options' ),
		],
		'fs' => [
			'adapter' => 'Standard',
			'tempdir' => storage_path( 'tmp' ),
			'basedir' => public_path(),
			'baseurl' => rtrim(env('ASSET_URL', PHP_SAPI == 'cli' ? env('APP_URL') : ''), '/'),
		],
		'fs-media' => [
			'adapter' => 'Standard',
			'tempdir' => storage_path( 'tmp' ),
			'basedir' => public_path( 'aimeos' ),
			'baseurl' => rtrim(env('ASSET_URL', PHP_SAPI == 'cli' ? env('APP_URL') : ''), '/') . '/aimeos',
		],
		'fs-mimeicon' => [
			'adapter' => 'Standard',
			'tempdir' => storage_path( 'tmp' ),
			'basedir' => public_path( 'vendor/shop/mimeicons' ),
			'baseurl' => rtrim(env('ASSET_URL', PHP_SAPI == 'cli' ? env('APP_URL') : ''), '/') . '/vendor/shop/mimeicons',
		],
		'fs-theme' => [
			'adapter' => 'Standard',
			'tempdir' => storage_path( 'tmp' ),
			'basedir' => public_path( 'vendor/shop/themes' ),
			'baseurl' => rtrim(env('ASSET_URL', PHP_SAPI == 'cli' ? env('APP_URL') : ''), '/') . '/vendor/shop/themes',
		],
		'fs-admin' => [
			'adapter' => 'Standard',
			'tempdir' => storage_path( 'tmp' ),
			'basedir' => storage_path( 'admin' ),
		],
		'fs-export' => [
			'adapter' => 'Standard',
			'tempdir' => storage_path( 'tmp' ),
			'basedir' => storage_path( 'export' ),
		],
		'fs-import' => [
			'adapter' => 'Standard',
			'tempdir' => storage_path( 'tmp' ),
			'basedir' => storage_path( 'import' ),
		],
		'fs-secure' => [
			'adapter' => 'Standard',
			'tempdir' => storage_path( 'tmp' ),
			'basedir' => storage_path( 'secure' ),
		],
		'mq' => [
			'adapter' => 'Standard',
			'db' => 'db',
		],
		'email' => [
			'from-email' => config( 'mail.from.address' ),
			'from-name' => config( 'mail.from.name' ),
		],
	],

	'admin' => [
		'jqadm' => [
			'api' => [
				'openai' => [
					'key' => env( 'SHOP_OPENAI_APIKEY' )
				],
				'translate' => [
					'key' => env( 'SHOP_DEEPL_APIKEY' )
				]
			]
		]
	],

	'client' => [
		'html' => [
			'basket' => [
				'cache' => [
					// 'enable' => false, // Disable basket content caching for development
				],
			],
			'common' => [
				'cache' => [
					// 'force' => true // enforce caching for logged in users
				],
			],
			'catalog' => [
				'lists' => [
					'basket-add' => true, // shows add to basket in list views
					// 'infinite-scroll' => true, // load more products in list view
					// 'size' => 48, // number of products per page
				],
				'selection' => [
					'type' => [// how variant attributes are displayed
						'color' => 'radio',
						'length' => 'radio',
						'width' => 'radio',
					],
				],
			],
		],
	],

	'controller' => [
		'frontend' => [
			'catalog' => [
				'levels-always' => 3 // number of category levels for mega menu
			]
		]
	],

	'i18n' => [
		'en' => [
			'client' => [
				'Suppliers' => ['Brands']
			]
		]
	],

	'madmin' => [
		'cache' => [
			'manager' => [
				// 'name' => 'None', // Disable caching for development
			],
		],
		'log' => [
			'manager' => [
				// 'loglevel' => 7, // Enable debug logging into madmin_log table
			],
		],
	],

	'mshop' => [
		'locale' => [
			// 'site' => '<custom site code>', // used instead of "default"
		]
	],


	'command' => [
	],

	'frontend' => [
	],

	'backend' => [
	],

];
