<?php

namespace Bixie\Download;

use Pagekit\Application as App;
use Bixie\Download\Model\File;
use Pagekit\Routing\ParamsResolverInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class UrlResolver implements ParamsResolverInterface
{
	const CACHE_KEY = 'download.routing';

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

		$slug = $parameters['slug'];

		$id = false;
		foreach ($this->cacheEntries as $entry) {
			if ($entry['slug'] === $slug) {
				$id = $entry['id'];
			}
		}

		if (!$id) {

			if (!$file = File::where(compact('slug'))->first()) {
				App::abort(404, 'File not found.');
			}

			$this->addCache($file);
			$id = $file->id;
		}

		$parameters['id'] = $id;
		return $parameters;
	}

	/**
	 * {@inheritdoc}
	 */
	public function generate(array $parameters = [])
	{
		$id = $parameters['id'];

		if (!isset($this->cacheEntries[$id])) {

			if (!$file = File::where(compact('id'))->first()) {
				throw new RouteNotFoundException('File not found.');
			}

			$this->addCache($file);
		}

		$meta = $this->cacheEntries[$id];

		$parameters['slug'] = $meta['slug'];

		unset($parameters['id']);
		return $parameters;
	}

	public function __destruct()
	{
		if ($this->cacheDirty) {
			App::cache()->save(self::CACHE_KEY, $this->cacheEntries);
		}
	}

	protected function addCache($file)
	{
		$this->cacheEntries[$file->id] = [
			'id'     => $file->id,
			'slug'   => $file->slug,
			'year'   => $file->date->format('Y'),
			'month'  => $file->date->format('m'),
			'day'    => $file->date->format('d'),
			'hour'   => $file->date->format('H'),
			'minute' => $file->date->format('i'),
			'second' => $file->date->format('s'),
		];

		$this->cacheDirty = true;
	}
}
