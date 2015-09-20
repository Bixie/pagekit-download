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
	use  DataModelTrait, FileModelTrait, AccessModelTrait;

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

	public function getDownloadLink () {
		if (!$this->id) {
			return false;
		}
		return App::url('@download/file/id', ['id' => $this->id, 'key' => App::module('bixie/download')->getDownloadKey($this)], 'base');
	}

	public static function getStatuses () {
		return [
			self::STATUS_PUBLISHED => __('Published'),
			self::STATUS_UNPUBLISHED => __('Unpublished')
		];
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
			'fileName' => basename($this->path),
			'download' => $this->getDownloadLink(),
			'url' => App::url('@download/id', ['id' => $this->id ?: 0], 'base')
		];

		return $this->toArray($data);
	}
}
