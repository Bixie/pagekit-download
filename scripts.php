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
				$table->addIndex(['status'], 'DOWNLOAD_FILE_STATUS');
			});
		}

		if ($util->tableExists('@download_category') === false) {
			$util->createTable('@download_category', function ($table) {
				$table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
				$table->addColumn('parent_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
				$table->addColumn('priority', 'integer', ['default' => 0]);
				$table->addColumn('status', 'smallint');
				$table->addColumn('title', 'string', ['length' => 255]);
				$table->addColumn('slug', 'string', ['length' => 255]);
				$table->addColumn('path', 'string', ['length' => 1023]);
				$table->addColumn('roles', 'simple_array', ['notnull' => false]);
				$table->addColumn('data', 'json_array', ['notnull' => false]);
				$table->setPrimaryKey(['id']);
			});
		}

		if ($util->tableExists('@download_files_categories') === false) {
			$util->createTable('@download_files_categories', function ($table) {
				$table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
				$table->addColumn('file_id', 'integer', ['unsigned' => true, 'length' => 10]);
				$table->addColumn('category_id', 'integer', ['unsigned' => true, 'length' => 10]);
				$table->addColumn('catordering', 'integer', ['default' => 0]);
				$table->setPrimaryKey(['id']);
				$table->addIndex(['file_id'], 'DOWNLOAD_FILESCATS_FILE_ID');
				$table->addIndex(['category_id'], 'DOWNLOAD_FILESCATS_CAT_ID');
			});
		}

	},

    'uninstall' => function ($app) {

        $util = $app['db']->getUtility();

        if ($util->tableExists('@download_file')) {
            $util->dropTable('@download_file');
        }

        if ($util->tableExists('@download_category')) {
            $util->dropTable('@download_category');
        }

        if ($util->tableExists('@download_files_categories')) {
            $util->dropTable('@download_files_categories');
        }

		// remove the config
		$app['config']->remove('bixie/download');

	}

];