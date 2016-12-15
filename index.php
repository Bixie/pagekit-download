<?php

use Bixie\Download\Event\RouteListener;
use Bixie\Download\Event\CategoryListener;
use Bixie\Download\Event\FileListener;

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
				'Bixie\\Download\\Controller\\FileApiController',
				'Bixie\\Download\\Controller\\CategoryApiController'
			]
		]

	],

	'resources' => [

		'bixie/download:' => ''

	],

	'menu' => [

		'download' => [
			'label' => 'Downloads',
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

		'download: categories' => [
			'label' => 'Categories',
			'parent' => 'download',
			'url' => '@download/admin/categories',
			'access' => 'download: manage categories',
			'active' => '@download/admin/categor*'
		],

		'download: settings' => [
			'label' => 'Settings',
			'parent' => 'download',
			'url' => '@download/settings',
			'access' => 'download: manage settings',
			'active' => '@download/settings*'
		]

	],

	'widgets' => [

		'widgets/downloads.php'

	],

	'permissions' => [

		'download: manage download' => [
			'title' => 'Manage downloads'
		],

		'download: manage categories' => [
			'title' => 'Manage categories'
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
		'show_subcategories' => true,
		'subcategories_columns' => 3,
		'subcategories_panel_style' => 'uk-panel-box uk-panel-box-secondary',
		'subcategories_content_align' => 'left',
		'subcategories_title_size' => 'uk-h3',
		'columns' => 1,
		'columns_small' => 2,
		'columns_medium' => '',
		'columns_large' => 4,
		'columns_xlarge' => 6,
		'columns_gutter' => 20,
		'filter_items' => 'category',
		'teaser' => [
			'show_title' => true,
			'show_subtitle' => true,
			'show_image' => true,
			'show_tags' => true,
			'show_date' => true,
			'show_version' => true,
			'show_category' => true,
			'show_readmore' => true,
			'show_download' => true,
			'show_demo' => true,
			'panel_style' => 'uk-panel-box',
			'content_align' => 'left',
			'tags_align' => 'center',
			'button_align' => '',
			'title_size' => 'uk-h3',
			'subtitle_size' => 'uk-h4',
			'title_color' => '',
			'download' => 'Download',
			'download_style' => 'uk-button uk-button-success',
			'read_more' => 'Details',
			'read_more_style' => 'uk-button',
			'demo' => 'Demo',
			'demo_style' => 'uk-button uk-button-primary'
		],
		'category' => [
			'show_title' => true,
			'show_image' => true,
			'show_description' => true,
			'filter_items' => true,
			'image_align' => 'left',
			'columns' => 1,
			'columns_small' => 2,
			'columns_medium' => '',
			'columns_large' => 4,
			'columns_xlarge' => 6,
			'columns_gutter' => 20,
		],
		'file' => [
			'image_align' => 'center',
			'metadata_position' => 'content-top',
			'tags_align' => 'uk-flex-center',
			'tags_position' => 'sidebar',
			'show_navigation' => 'bottom',
			'download' => 'Download',
			'download_style' => 'uk-button',
			'download_align' => 'center'
		],
		'routing' => 'category',
		'ordering' => 'title',
		'ordering_dir' => 'asc',
		'files_per_page' => 20,
		'count_admindownloads' => false,
		'file_extensions' => ['zip', 'rar', 'tar.gz'],
		'markdown_enabled' => false,
		'date_format' => 'd F Y',
		'tags' => [],
		'datafields' => []
	],

	'events' => [

		'boot' => function ($event, $app) {
			$app->subscribe(
				new RouteListener,
				new CategoryListener,
				new FileListener
			);
			if (class_exists('Bixie\Cart\CartModule')) {
				$app->subscribe(
					new Bixie\Download\Cart\FileListener
				);
			}
//			$app->extend('view', function ($view) use ($app) {
//				return $view->addHelper(new DownloadImageHelper($app));
//			});
			//todo event to clear cache?
		},

		'view.styles' => function ($event, $styles) use ($app) {
			$styles->register('uikit-sortable', 'app/assets/uikit/css/components/sortable.min.css');
		},

		'view.scripts' => function ($event, $scripts) use ($app) {

			$scripts->register('bixie-downloads', 'bixie/download:app/bundle/downloads.js');
			$scripts->register('uikit-grid', 'app/assets/uikit/js/components/grid.min.js', 'uikit');
			$scripts->register('uikit-lightbox', 'app/assets/uikit/js/components/lightbox.min.js', 'uikit');
			$scripts->register('uikit-sortable', 'app/assets/uikit/js/components/sortable.min.js', 'uikit');
			$scripts->register('uikit-slider', 'app/assets/uikit/js/components/slider.min.js', 'uikit');
		},

		'console.init' => function ($event, $console) {

			$console->add(new \Bixie\Download\Console\Commands\TranslateCommand());

		}
	]

];
