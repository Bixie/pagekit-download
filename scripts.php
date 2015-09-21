<?php

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