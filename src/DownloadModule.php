<?php

namespace Bixie\Download;

use Pagekit\Application as App;
use Pagekit\Module\Module;
use Bixie\Download\Model\File;

class DownloadModule extends Module {


	/**
	 * {@inheritdoc}
	 */
	public function main (App $app) {

		$app->on('boot', function () {
			$this->framework = App::module('bixie/pk-framework');
		});

	}

	public function getDownloadKey (File $file, $purchaseKey = '') {
		$session_key = $this->getSessionKey($file, $purchaseKey);
		App::session()->set("_bixieDownload.downloadkey.{$file->id}", $session_key);
		return $session_key;
	}

	public function checkDownloadKey (File $file, $key, $purchaseKey = '') {
		$check_key = $this->getSessionKey($file, $purchaseKey);
		if ($file->id > 0
			and $check_key === $key
			and $key === App::session()->get("_bixieDownload.downloadkey.{$file->id}")) {

			return true;
		}
		return false;
	}

	protected function getSessionKey ($file, $purchaseKey) {
		return sha1(App::system()->config('key') . '.' . App::session()->getId() . '.' . $file->id . '.' . $purchaseKey );
	}

}
