<?php

namespace Bixie\Download;

use Bixie\Download\Model\Category;
use Pagekit\Application as App;
use Bixie\Download\Model\File;
use Pagekit\Routing\ParamsResolverInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class CategoryUrlResolver implements ParamsResolverInterface
{
	const CACHE_KEY = 'download.routing.category';

	/**
	 * @var bool
	 */
	protected $cacheDirty = false;

	/**
	 * @var array
	 */
	protected $cacheEntries;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->cacheEntries = App::cache()->fetch(self::CACHE_KEY) ?: [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function match(array $parameters = [])
	{
		if (isset($parameters['id'])) {
			return $parameters;
		}

		if (!isset($parameters['slug'])) {
			App::abort(404, 'File not found.');
		}

		if (!isset($parameters['category_id'])) {
			App::abort(404, 'No category provided.');
		}

		$slug = $parameters['slug'];
		$category_id = $parameters['category_id'];

		$id = false;
		foreach ($this->cacheEntries as $entry) {
			if ($entry['slug'] === $slug && $entry['category_id'] === $category_id) {
				$id = $entry['id'];
			}
		}

		if (!$id) {
			/** @var File $file */
			if (!$file = File::where(compact('slug'))->related('categories')->first()) {
				App::abort(404, 'File not found.');
			}
			if (!in_array($category_id, $file->getCategoryIds())) {
				App::abort(400, 'File not in category');
			}
			if (!$category = Category::where(['id' => $category_id])->first()) {
				App::abort(404, 'Category not found.');
			}

			$this->addCache($file, $category->id, $category->slug);

			$category_id = $category->id;
			$id = $file->id;
		}

		$parameters['id'] = $id;
		$parameters['category_id'] = $category_id;
		return $parameters;
	}

	/**
	 * {@inheritdoc}
	 */
	public function generate(array $parameters = [])
	{
		$id = $parameters['id'];
		$category_id = isset($parameters['category_id']) ? $parameters['category_id'] : 0;

		if (!isset($this->cacheEntries[$id . '-' . $category_id])) {

			if (!$file = File::find($id)) {
				throw new RouteNotFoundException('File not found.');
			}

			if ($category_id && !$category = Category::find($category_id)) {
				throw new RouteNotFoundException('Category not found.');
			}

			$this->addCache($file, $category_id, (isset($category) ? $category->slug: App::config('bixie/download')->get('root_category', 'root')));
		}

		$meta = $this->cacheEntries[$id . '-' . $category_id];

		$parameters['slug'] = $meta['slug'];

		unset($parameters['id']);
		unset($parameters['category_id']);
		return $parameters;
	}

	public function __destruct()
	{
		if ($this->cacheDirty) {
			App::cache()->save(self::CACHE_KEY, $this->cacheEntries);
		}
	}

	protected function addCache($file, $category_id, $category_slug = '')
	{
		$this->cacheEntries[$file->id . '-' . $category_id] = [
			'id'     => $file->id,
			'slug'   => $file->slug,
			'category_id'   => $category_id,
			'category_slug'   => $category_slug
		];

		$this->cacheDirty = true;
	}
}
