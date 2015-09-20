<?php

use Bixie\Download\Event\RouteListener;

return [

	'name' => 'bixie/download',

	'type' => 'extension',

	'main' => 'Bixie\\Download\\DownloadModule',

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
				'Bixie\\Download\\Controller\\DownloadController',
				'Bixie\\Download\\Controller\\FileController'
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
		'mainpage_title' => '',
		'mainpage_text' => '',
		'mainpage_image' => '',
		'mainpage_image_align' => 'left',
		'columns' => 1,
		'columns_small' => 2,
		'columns_medium' => '',
		'columns_large' => 4,
		'columns_xlarge' => 6,
		'columns_gutter' => 20,
		'filter_tags' => true,
		'teaser' => [
			'show_title' => true,
			'show_subtitle' => true,
			'show_image' => true,
			'show_tags' => true,
			'show_date' => true,
			'show_readmore' => true,
			'show_download' => true,
			'panel_style' => 'uk-panel-box',
			'content_align' => 'left',
			'tags_align' => 'uk-flex-center',
			'button_align' => 'uk-flex-space-around',
			'title_size' => 'uk-h3',
			'subtitle_size' => 'uk-h4',
			'title_color' => '',
			'download' => 'Download',
			'download_style' => 'uk-button uk-button-success',
			'read_more' => 'Details',
			'read_more_style' => 'uk-button'
		],
		'file' => [
			'image_align' => 'left',
			'metadata_position' => 'content-top',
			'tags_align' => 'uk-flex-center',
			'tags_position' => 'sidebar',
			'show_navigation' => 'bottom',
			'download' => 'Download',
			'download_style' => 'uk-button',
			'download_align' => 'uk-text-center'
		],
		'ordering' => 'title',
		'ordering_dir' => 'asc',
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
