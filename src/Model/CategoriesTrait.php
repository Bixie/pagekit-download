<?php

namespace Bixie\Download\Model;


trait CategoriesTrait
{

	/**
	 * @ManyToMany(
	 *            targetEntity="Category",
	 *            tableThrough="@download_files_categories",
	 *            keyThroughFrom="file_id",
	 *            keyThroughTo="category_id"
	 * )
	 */
	public $categories;

	public function getCategoryIds () {
		if ($this->categories) {
			return array_values(array_map(function ($category) {
				return $category->id;
			}, $this->categories));
		}
		return [];
	}

	public function getCategoryTitles () {
		if ($this->categories) {
			return array_values(array_map(function ($category) {
				return $category->title;
			}, $this->categories));
		}
		return [];
	}

	public function addCategory (Category $category) {
		$this->categories[$category->id] = $category;
	}

	public function removeCategory (Category $category) {
		unset($this->categories[$category->id]);
	}

	public function saveCategories (array $category_ids) {
		$remove = array_diff(array_keys($this->categories), $category_ids);
		foreach ($remove as $category_id) {
			if ($xref = FilesCategories::query(['file_id' => $this->id, 'category_id' => $category_id])->first()) {
				$xref->delete();
			}
		}
		foreach ($category_ids as $category_id) {
			if (!in_array($category_id, $remove) && !isset($this->categories[$category_id])) {
				if ($category = Category::find($category_id)) {
					$this->addCategory($category);
					$category->addFile($this);
					$xref = FilesCategories::create(['file_id' => $this->id, 'category_id' => $category->id]);
					$xref->save();
				}
			}
		}
	}



}