<?php

namespace Bixie\Download\Model;

use Pagekit\Application as App;
use Pagekit\Database\ORM\ModelTrait;

/**
 * Class FileModelTrait
 * @package Bixie\Download\Model
 */
trait FileModelTrait
{
    use ModelTrait;

	/**
	 * @return array
	 */
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
	 * @param File $file
	 * @return mixed
	 */
	public static function getPrevious ($file) {
		$module = App::module('bixie/download');
		return self::where(['title > ?', 'status = ?'], [$file->title, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->orderBy($module->config('ordering'), $module->config('ordering_dir'))->first();
	}

	/**
	 * @param File $file
	 * @return mixed
	 */
	public static function getNext ($file) {
		$module = App::module('bixie/download');
		return self::where(['title < ?', 'status = ?'], [$file->title, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->orderBy($module->config('ordering'), $module->config('ordering_dir'))->first();
	}

	/**
     * @Saving
     */
    public static function saving($event, File $file)
    {
		//slug
        $i  = 2;
        $id = $file->id;

        while (self::where('slug = ?', [$file->slug])->where(function ($query) use ($id) {
            if ($id) {
                $query->where('id <> ?', [$id]);
            }
        })->first()) {
			$file->slug = preg_replace('/-\d+$/', '', $file->slug).'-'.$i++;
        }

    }

}
