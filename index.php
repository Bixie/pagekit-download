<?php

use Bixie\Download\Event\RouteListener;

return [

	'name' => 'bixie/download',

	'type' => 'extension',

	'autoload' => [

		'Bixie\\Download\\' => 'src'

	],

	'nodes' => [

		'download' => [
			'name' => '@download',
			'label' => 'Download manager',
			'controller' => 'Bixie\\Download\\Controller\\SiteController',
			'protected' => true,
			'frontpage' => true
		]

	],

	'routes' => [

		'/download' => [
			'name' => '@download',
			'controller' => [
				'Bixie\\Download\\Controller\\DownloadController'
			]
		],
		'/api/download' => [
			'name' => '@download/api',
			'controller' => [
				'Bixie\\Download\\Controller\\FileApiController'
			]
		]

	],

	'resources' => [

		'bixie/download:' => ''

	],

	'menu' => [

		'download' => [
			'label' => 'Download manager',
			'icon' => 'bixie/download:icon.svg',
			'url' => '@download/download',
			'access' => 'download: manage downloads',
			'active' => '@download/download*'
		],

		'download: project' => [
			'label' => 'Downloads',
			'parent' => 'download',
			'url' => '@download/download',
			'access' => 'download: manage downloads',
			'active' => '@download/file*'
		],

		'download: settings' => [
			'label' => 'Settings',
			'parent' => 'download',
			'url' => '@download/settings',
			'access' => 'download: manage settings',
			'active' => '@download/settings*'
		]

	],

	'permissions' => [

		'download: manage download' => [
			'title' => 'Manage downloads'
		],

		'download: manage settings' => [
			'title' => 'Manage settings'
		]

	],

	'settings' => '@download/settings',

	'config' => [
		'files_per_page' => 20,
		'markdown_enabled' => false,
		'date_format' => 'd F Y',
		'tags' => []
	],

	'events' => [

		'boot' => function ($event, $app) {
			$app->subscribe(
				new RouteListener
			);
//			$app->extend('view', function ($view) use ($app) {
//				return $view->addHelper(new DownloadImageHelper($app));
//			});
			//todo event to clear cache?
		},

		'view.scripts' => function ($event, $scripts) use ($app) {

			$scripts->register('uikit-grid', 'app/assets/uikit/js/components/grid.min.js', 'uikit');
			$scripts->register('uikit-lightbox', 'app/assets/uikit/js/components/lightbox.min.js', 'uikit');
			$scripts->register('node-download', 'download:app/bundle/node-download.js', '~site-edit');
		},

		'console.init' => function ($event, $console) {

			//$console->add(new \Bixie\Download\Console\Commands\DownloadTranslateCommand());

		}
	]

];
