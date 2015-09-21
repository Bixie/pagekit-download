<?php
use Pagekit\Site\Model\Node;

return [

    'install' => function ($app) {

		$util = $app['db']->getUtility();

		if ($util->tableExists('@download_file') === false) {
			$util->createTable('@download_file', function ($table) {
				$table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
				$table->addColumn('status', 'smallint');
				$table->addColumn('roles', 'simple_array', ['notnull' => false]);
				$table->addColumn('title', 'string', ['length' => 255]);
				$table->addColumn('subtitle', 'string', ['length' => 255, 'notnull' => false]);
				$table->addColumn('slug', 'string', ['length' => 255]);
				$table->addColumn('path', 'text');
				$table->addColumn('content', 'text', ['notnull' => false]);
				$table->addColumn('date', 'datetime');
				$table->addColumn('tags', 'simple_array', ['notnull' => false]);
				$table->addColumn('image', 'json_array', ['notnull' => false]);
				$table->addColumn('data', 'json_array', ['notnull' => false]);
				$table->setPrimaryKey(['id']);
				$table->addUniqueIndex(['slug'], 'DOWNLOAD_FILE_SLUG');
			});
		}
		//temp fix trigger install node
		$nodes = [

			'download' => [
				'name' => '@download',
				'label' => 'Download',
				'controller' => 'Bixie\\Download\\Controller\\SiteController',
				'protected' => true,
				'frontpage' => true
			]

		];
		foreach ($nodes as $type => $route) {
			if (isset($route['protected']) and $route['protected'] and !Node::where(['type = ?'], [$type])->first()) {
				Node::create([
					'title' => $route['label'],
					'slug' => $app->filter($route['label'], 'slugify'),
					'type' => $type,
					'status' => 1,
					'link' => $route['name']
				])->save();
			}
		}

    },

    'uninstall' => function ($app) {

        $util = $app['db']->getUtility();

        if ($util->tableExists('@download_file')) {
            $util->dropTable('@download_file');
        }

		// remove the config
		$app['config']->remove('bixie/download');

	}

];