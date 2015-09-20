<?php

namespace Bixie\Download;

use Pagekit\Application as App;
use Pagekit\Module\Module;
use Bixie\Download\Model\File;

class DownloadModule extends Module {
	/**
	 * @var array
	 */
	protected $types;

	/**
	 * {@inheritdoc}
	 */
	public function main (App $app) {

	}

	public function getDownloadKey (File $file) {
		//todo
		$key = 'df.' . $file->slug;
		return $key;
	}

	public function checkDownloadKey (File $file, $key) {
		//todo
		return $file->id > 0;
	}

}
