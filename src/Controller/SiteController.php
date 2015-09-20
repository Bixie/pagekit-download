<?php

namespace Bixie\Download\Controller;

use Pagekit\Application as App;
use Pagekit\Module\Module;
use Bixie\Download\Model\File;

class SiteController
{
    /**
     * @var Module
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

        $query = File::where(['date < ?'], [new \DateTime])->orderBy('date', 'DESC');

		$portfolio_text = '';
		if ($this->download->config('portfolio_text')) {
			$portfolio_text = App::content()->applyPlugins($this->portfolio->config('portfolio_text'), ['markdown' => $this->portfolio->config('markdown_enabled')]);;
		}

		foreach ($projects = $query->get() as $project) {
			$project->intro = App::content()->applyPlugins($project->intro, ['project' => $project, 'markdown' => $project->get('markdown')]);
			$project->content = App::content()->applyPlugins($project->content, ['project' => $project, 'markdown' => $project->get('markdown'), 'readmore' => true]);
        }

        return [
            '$view' => [
                'title' => $this->download->config('portfolio_title') ?: App::node()->title,
                'name' => 'portfolio/portfolio.php'
            ],
			'tags' => Project::allTags(),
      		'download' => $this->download,
			'config' => $this->download->config(),
			'portfolio_text' => $portfolio_text,
            'projects' => $projects
        ];
    }

    /**
     * @Route("/{id}", name="id")
     */
    public function projectAction($id = 0)
    {
        if (!$project = File::where(['id = ?', 'date < ?'], [$id, new \DateTime])->first()) {
            App::abort(404, __('Project not found.'));
        }

        $project->intro = App::content()->applyPlugins($project->intro, ['project' => $project, 'markdown' => $project->get('markdown')]);
        $project->content = App::content()->applyPlugins($project->content, ['project' => $project, 'markdown' => $project->get('markdown')]);

		$portfolio_text = '';
		if ($this->portfolio->config('portfolio_text')) {
			$portfolio_text = App::content()->applyPlugins($this->portfolio->config('portfolio_text'), ['markdown' => $project->get('markdown')]);;
		}

		$previous = File::getPrevious($project);
		$next = File::getNext($project);

        return [
            '$view' => [
                'title' => __($project->title),
                'name' => 'download/project.php'
            ],
            'portfolio' => $this->portfolio,
			'config' => $this->portfolio->config(),
			'previous' => $previous,
			'next' => $next,
			'project' => $project
        ];
    }
}
