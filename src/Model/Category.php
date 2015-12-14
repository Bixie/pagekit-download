<?php

namespace Bixie\Download\Model;

use Pagekit\Application as App;
use Pagekit\System\Model\DataModelTrait;
use Pagekit\System\Model\NodeInterface;
use Pagekit\System\Model\NodeTrait;
use Pagekit\User\Model\AccessModelTrait;
use Pagekit\User\Model\User;

/**
 * @Entity(tableClass="@download_category",eventPrefix="download")
 */
class Category implements NodeInterface, \JsonSerializable
{
    use AccessModelTrait, DataModelTrait, CategoryModelTrait, NodeTrait;

    /** @Column(type="integer") @Id */
    public $id;

    /** @Column(type="integer") */
    public $parent_id = 0;

    /** @Column(type="integer") */
    public $priority = 0;

    /** @Column(type="integer") */
    public $status = 0;

    /** @Column(type="string") */
    public $slug;

    /** @Column(type="string") */
    public $path;

    /** @Column(type="string") */
    public $title;

	/**
	 * @ManyToMany(
	 *            targetEntity="File",
	 *            tableThrough="@download_files_categories",
	 *            keyThroughFrom="category_id",
	 *            keyThroughTo="file_id"
	 * )
	 *  //not implemented: orderBy = {"catordering": "ASC"}
	 *  @var File[]
	 */
	public $files;

	/** @var array */
    protected static $properties = [
        'accessible' => 'isAccessible'
    ];

	/**
	 * @return File[]
	 */
	public function getFiles () {
		if ($this->files) {
			$catordering = FilesCategories::setCatordering($this);
			return array_values(array_map(function ($file) use ($catordering) {
				return $file->toArray(['catordering' => $catordering[$file->id]], ['path','content','tags','image','data']);
			}, $this->files));
		}
		return [];
	}

	/**
	 * @param $data
	 */
	public function updateOrdering ($data) {
		if ($this->files) {
			foreach ($data['files'] as $fileData) {
				if ($this->files[$fileData['id']]) {
					FilesCategories::saveCatordering($this->files[$fileData['id']], $this, $fileData['catordering']);
				}
			}
		}
	}

	/**
     * Gets the category URL.
     *
     * @param  mixed  $referenceType
     * @return string|bool
     */
    public function getUrl($referenceType = false)
    {
        return App::url('@download/category/' . $this->id, [], $referenceType);
    }

	/**
	 * @param User|null $user
	 * @return bool
	 */
	public function isAccessible(User $user = null)
    {
        return $this->status && $this->hasAccess($user ?: App::user());
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
		$data = [
			'files' => $this->getFiles(),
			'url' => $this->getUrl()
		];
		return $this->toArray($data);
    }
}
