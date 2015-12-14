<?php

namespace Bixie\Download\Model;

use Pagekit\Application as App;
use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@download_files_categories",eventPrefix="download")
 */
class FilesCategories implements \JsonSerializable
{
    use ModelTrait;

    /** @Column(type="integer") @Id */
    public $id;

    /** @Column(type="integer") */
    public $file_id;

    /** @Column(type="integer") */
    public $category_id;

    /** @Column(type="integer") */
    public $catordering;

	public static function setCatordering (Category $category) {
		//todo fix this in ManyToMany?
		$ordered = [];
		$catordering = [];
		if ($category->files) {
			$xrefs = self::where(['category_id' => $category->id])->orderBy('catordering', 'ASC')->get();
			foreach ($xrefs as $xref) {
				$catordering[$xref->file_id] = $xref->catordering;
				$ordered[$xref->file_id] = $category->files[$xref->file_id];
			}
			$category->files = $ordered;
		}
		return $catordering;
	}

	public static function saveCatordering (File $file, Category $category, $catordering) {
		return self::query()
			->where(['file_id' => $file->id, 'category_id' => $category->id])
			->update(['catordering' => $catordering]);
	}

	/**
	 * @Saving
	 */
	public static function saving ($event, FilesCategories $xref) {

		if (!is_numeric($xref->catordering)) {
			$xref->catordering = 1 + self::getConnection()->fetchColumn('SELECT MAX(catordering) FROM @download_files_categories WHERE category_id = ' . (int) $xref->category_id);
		}
	}

	/**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
