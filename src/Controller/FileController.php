<?php

namespace Bixie\Download\Controller;

use Pagekit\Application as App;
use Pagekit\Module\Module;
use Bixie\Download\Model\File;

/**
 * @Route("file", name="file")
 */
class FileController
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
     * @Route("/{id}", name="id")
     */
    public function downloadAction($id = 0)
    {
        if (!$file = File::where(['id = ?', 'status = ?'], [$id, 1])->first()) {
            App::abort(404, __('File not found.'));
        }

		if (!$file->hasAccess(App::user())) {
			App::abort(403, __('Insufficient User Rights.'));
		}



		return [$file->path];

    }
}
