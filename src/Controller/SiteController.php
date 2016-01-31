<?php

namespace Bixie\Download\Controller;

use Pagekit\Application as App;
use Bixie\Download\Model\File;
use Bixie\Download\Model\Category;

class SiteController
{
    /**
     * @var \Bixie\Download\DownloadModule
     */
    protected $download;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->download = App::module('bixie/download');
    }

    /**
     * @Route("/")
	 */
    public function indexAction()
    {
        if (!App::node()->hasAccess(App::user())) {
            App::abort(403, __('Insufficient User Rights.'));
        }

        $query = File::where(['status = ?'], ['1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->orderBy($this->download->config('ordering'), $this->download->config('ordering_dir'));

		if ($this->download->config('ordering') == 'tags') {
			$query->orderBy('title', $this->download->config('ordering_dir'));
		}

		$mainpage_text = '';
		if ($this->download->config('mainpage_text')) {
			$mainpage_text = App::content()->applyPlugins($this->download->config('mainpage_text'), ['markdown' => $this->download->config('markdown_enabled')]);;
		}

		$filters = [];
		foreach ($files = $query->related('categories')->get() as $file) {
			App::trigger('bixie.prepare.file', [$file, App::view()]);
			$file->content = App::content()->applyPlugins($file->content, ['file' => $file, 'markdown' => $file->get('markdown')]);

			$filters = array_merge($filters, $file->getFilters($this->download->config('filter_items')));
        }
		$filters = array_unique($filters);
		natsort($filters);

		$subcategories = Category::where(['parent_id = ?', 'status = ?'], [0, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->orderBy('priority', 'ASC')->get();

		return [
            '$view' => [
                'title' => $this->download->config('download_title') ?: App::node()->title,
                'name' => 'bixie/download/download.php'
            ],
			'filters' => $filters,
      		'download' => $this->download,
			'config' => $this->download->config(),
			'mainpage_text' => $mainpage_text,
			'subcategories' => $subcategories,
			'files' => $files,
			'node' => App::node()
        ];
    }

    /**
     * @Route("/{id}", name="id")
	 * @Request({"id":"int"})
	 */
    public function categoryAction($id = 0)
    {
		/** @var Category $category */
		if (!$category = Category::where(['id = ?', 'status = ?'], [$id, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->related('files')->first()) {
			App::abort(404, __('Category not found.'));
		}

		$category->set('description', App::content()->applyPlugins($category->get('description'), ['category' => $category, 'markdown' => $category->get('markdown')]));

		$filters = [];
		foreach ($category->files as &$file) {
			App::trigger('bixie.prepare.file', [$file, App::view()]);
			$file->content = App::content()->applyPlugins($file->content, ['file' => $file, 'markdown' => $file->get('markdown')]);

			$filters = array_merge($filters, $file->tags);
		}
		$filters = array_unique($filters);
		natsort($filters);

		$subcategories = Category::where(['parent_id = ?', 'status = ?'], [$id, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->orderBy('priority', 'ASC')->get();

		if ($breadcrumbs = App::module('bixie/breadcrumbs')) {
			$cat = $category;
			$crumbs = [['title' => $category->title, 'url' => $category->getUrl()]];
			while ($parent_id = $cat->parent_id) {
				if ($cat = $cat->find($parent_id, true)) {
					$crumbs[] = ['title' => $cat->title, 'url' => $cat->getUrl()];
				}
			}
			foreach (array_reverse($crumbs) as $data) {
				$breadcrumbs->addUrl($data);
			}
		}

		return [
			'$view' => [
				'title' => __($category->title),
				'name' => 'bixie/download/category.php'
			],
			'filters' => $filters,
			'download' => $this->download,
			'config' => $this->download->config(),
			'subcategories' => $subcategories,
			'category' => $category,
			'node' => App::node()
		];
	}

    /**
     * @Route("/{id}", name="id")
	 * @Request({"id":"int", "category_id":"int"})
	 */
    public function fileAction($id = 0, $category_id = 0)
    {

		/** @var File $file */
		if (!$file = File::where(['id = ?', 'status = ?'], [$id, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->first()) {
            App::abort(404, __('File not found.'));
        }

		$file->setActiveCategory($category_id);

		App::trigger('bixie.prepare.file', [$file, App::view()]);
		$file->content = App::content()->applyPlugins($file->content, ['file' => $file, 'markdown' => $file->get('markdown')]);

		$previous = File::getPrevious($file);
		$next = File::getNext($file);

		/** @var Category $category */
		if ($category_id && !$category = Category::where(['id = ?', 'status = ?'], [$category_id, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->related('files')->first()) {
			App::abort(404, __('Category not found.'));
		}
		if ($breadcrumbs = App::module('bixie/breadcrumbs')) {
			if ($category_id) {
				$cat = $category;
				$crumbs = [['title' => $category->title, 'url' => $category->getUrl()]];
				while ($parent_id = $cat->parent_id) {
					if ($cat = $cat->find($parent_id, true)) {
						$crumbs[] = ['title' => $cat->title, 'url' => $cat->getUrl()];
					}
				}
				foreach (array_reverse($crumbs) as $data) {
					$breadcrumbs->addUrl($data);
				}
			}
			//add file
			$breadcrumbs->addUrl(['title' => $file->title, 'url' => $file->getUrl()]);
		}

		return [
            '$view' => [
                'title' => __($file->title),
                'name' => 'bixie/download/file.php'
            ],
            'download' => $this->download,
			'config' => $this->download->config(),
			'previous' => $previous,
			'next' => $next,
			'file' => $file,
			'node' => App::node()
        ];
    }
}
