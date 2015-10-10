<?php

namespace Bixie\Download\Model;

use Pagekit\Application as App;
use Pagekit\System\Model\DataModelTrait;
use Pagekit\User\Model\AccessModelTrait;

/**
 * @Entity(tableClass="@download_file")
 */
class File implements \JsonSerializable
{
	use FileModelTrait, AccessModelTrait, DataModelTrait, CategoriesTrait;

	/* File published. */
	const STATUS_PUBLISHED = 1;

	/* File unpublished. */
	const STATUS_UNPUBLISHED = 0;

	/** @Column(type="integer") @Id */
	public $id;

	/** @Column(type="integer") */
	public $status;

	/** @Column(type="string") */
	public $slug;

	/** @Column(type="string") */
	public $title;

	/** @Column(type="string") */
	public $subtitle;

	/** @Column(type="string") */
	public $path;

	/** @Column(type="text") */
	public $content = '';

	/** @Column(type="datetime") */
	public $date;

	/** @Column(type="simple_array") */
	public $tags;

	/** @Column(type="json_array") */
	public $image;

	public static function allTags () {
		//todo cache this
		$tags = App::module('bixie/download')->config('tags');
		foreach (self::findAll() as $file) {
			if (is_array($file->tags)) {
				$tags = array_merge($tags, $file->tags);
			}
		}
		$tags = array_unique($tags);
		natsort($tags);
		return $tags;
	}

	/**
	 * @param string $purchaseKey optional
	 * @return bool
	 */
	public function getDownloadLink ($purchaseKey = '') {
		if (!$this->id) {
			return false;
		}
		return App::url('@download/file/id', [
			'id' => $this->id,
			'key' => App::module('bixie/download')->getDownloadKey($this, $purchaseKey),
			'pkey' => $purchaseKey
		], true);
	}

	public static function getStatuses () {
		return [
			self::STATUS_PUBLISHED => __('Published'),
			self::STATUS_UNPUBLISHED => __('Unpublished')
		];
	}

	public function getFileName () {
		return basename($this->path);
	}

	public function getStatusText () {
		$statuses = self::getStatuses();

		return isset($statuses[$this->status]) ? $statuses[$this->status] : __('Unknown');
	}

	public static function getPrevious ($file) {
		$module = App::module('bixie/download');
		return self::where(['title > ?', 'status = ?'], [$file->title, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->orderBy($module->config('ordering'), $module->config('ordering_dir'))->first();
	}

	public static function getNext ($file) {
		$module = App::module('bixie/download');
		return self::where(['title < ?', 'status = ?'], [$file->title, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->orderBy($module->config('ordering'), $module->config('ordering_dir'))->first();
	}

	/**
	 * {@inheritdoc}
	 */
	public function jsonSerialize () {
		$data = [
			'fileName' => $this->getFileName(),
			'download' => $this->getDownloadLink(),
			'category_titles' => $this->getCategoryTitles(),
			'category_ids' => $this->getCategoryIds(),
			'url' => App::url('@download/id', ['id' => $this->id ?: 0], 'base')
		];

		return $this->toArray($data);
	}
}
