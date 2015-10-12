<?php

namespace Bixie\Download\Controller;

use Pagekit\Application as App;
use Bixie\Download\Model\File;

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

        return [
            '$view' => [
                'title' => $this->download->config('download_title') ?: App::node()->title,
                'name' => 'bixie/download/download.php'
            ],
			'filters' => $filters,
      		'download' => $this->download,
			'config' => $this->download->config(),
			'mainpage_text' => $mainpage_text,
            'files' => $files,
			'node' => App::node()
        ];
    }

    /**
     * @Route("/{id}", name="id")
     */
    public function fileAction($id = 0)
    {
        if (!$file = File::where(['id = ?', 'status = ?'], [$id, '1'])->where(function ($query) {
			return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
		})->first()) {
            App::abort(404, __('File not found.'));
        }

		App::trigger('bixie.prepare.file', [$file, App::view()]);
		$file->content = App::content()->applyPlugins($file->content, ['file' => $file, 'markdown' => $file->get('markdown')]);

		$previous = File::getPrevious($file);
		$next = File::getNext($file);

        return [
            '$view' => [
                'title' => __($file->title),
                'name' => 'bixie/download/file.php'
            ],
            'portfolio' => $this->download,
			'config' => $this->download->config(),
			'previous' => $previous,
			'next' => $next,
			'file' => $file,
			'node' => App::node()
        ];
    }
}
