<?php

namespace Bixie\Download\Model;

use Pagekit\Application as App;
use Pagekit\System\Model\DataModelTrait;
use Pagekit\User\Model\AccessModelTrait;

/**
 * @Entity(tableClass="@download_file",eventPrefix="download_file")
 */
class File implements \JsonSerializable
{
	use FileModelTrait, AccessModelTrait, DataModelTrait, CategoriesTrait;

	/* File published. */
	/**
	 *
	 */
	const STATUS_PUBLISHED = 1;

	/* File unpublished. */
	/**
	 *
	 */
	const STATUS_UNPUBLISHED = 0;

	/** @Column(type="integer") @Id */
	public $id;

	/** @Column(type="integer") */
	public $status;

	/** @Column(type="integer") */
	public $downloads = 0;

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

	/** @var array */
	protected static $properties = [
		'activeCategory' => 'getActiveCategory'
	];

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

	/**
	 * @param int        $category_id
	 * @param bool|false $base
	 * @return string|bool
	 */
	public function getUrl ($category_id = 0, $base = false) {
		$category_id = $category_id ? : $this->get('primary_category', 0);
		if (!$category_id || App::config('bixie/download')->get('routing') == 'item') {
			return App::url('@download/id', ['id' => $this->id ?: 0], $base);
		} else {
			return App::url('@download/category/file/' . $category_id, ['id' => $this->id ?: 0], $base);
		}
	}

	/**
	 * @return array
	 */
	public static function getStatuses () {
		return [
			self::STATUS_PUBLISHED => __('Published'),
			self::STATUS_UNPUBLISHED => __('Unpublished')
		];
	}

	/**
	 * @return string
	 */
	public function getFileName () {
		return basename($this->path);
	}

	/**
	 * @return string
	 */
	public function getStatusText () {
		$statuses = self::getStatuses();

		return isset($statuses[$this->status]) ? $statuses[$this->status] : __('Unknown');
	}

	/**
	 * @param string|null $filter_type
	 * @return array|mixed
	 */
	public function getFilters ($filter_type = null) {
		$filter_type = $filter_type == null ? $filter_type : App::module('bixie/download')->config('filter_items');
		if ($filter_type == 'category') {
			return $this->getCategoryTitles();
		} elseif ($filter_type == 'tag') {
			return $this->tags;
		}
		return [];
	}

	/**
	 *
	 */
	public function updateDownloadCount() {
		if (!App::module('bixie/download')->config('count_admindownloads', false) && App::user()->isAdministrator()) {
			return;
		}

		self::where(['id' => $this->id])->update([
				'downloads' => $this->downloads + 1
			]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function jsonSerialize () {
		$data = [
			'filters' => $this->getFilters(),
			'fileName' => $this->getFileName(),
			'download' => $this->getDownloadLink(),
			'category_titles' => $this->getCategoryTitles(),
			'category_ids' => $this->getCategoryIds(),
			'url' => $this->getUrl()
		];

		return $this->toArray($data);
	}
}
