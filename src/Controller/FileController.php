<?php

namespace Bixie\Download\Controller;

use Pagekit\Application as App;
use Bixie\Download\Model\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route("file", name="file")
 */
class FileController
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
	 * @Route("/{id}", name="id")
	 * @Request({"id": "integer", "key": "string", "pkey": "string"})
	 * @param integer $id File id
	 * @param string $key session key
	 * @param string $purchaseKey optional purchase key
	 * @return BinaryFileResponse
	 */
    public function downloadAction($id, $key, $purchaseKey)
    {
        if (!$file = File::where(['id = ?', 'status = ?'], [$id, 1])->first()) {
            App::abort(404, __('File not found.'));
        }

		if (!$file->hasAccess(App::user())) {
			App::abort(403, __('Insufficient User Rights.'));
		}

		if (!$this->download->checkDownloadKey($file, $key, $purchaseKey)) {
			App::abort(403, __('Key not valid.'));
		}

		// Generate response
		$response = new BinaryFileResponse($file->path);
		$response->headers->set('Content-Disposition', $response->headers->makeDisposition(
			ResponseHeaderBag::DISPOSITION_ATTACHMENT,
			basename($file->path)
		));

		return $response;

    }
}
