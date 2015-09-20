<?php

namespace Bixie\Download\Controller;

use Pagekit\Application as App;
use Bixie\Download\Model\File;

/**
 * @Access(admin=true)
 */
class DownloadController
{
    /**
     * @Access("download: manage downloads")
     * @Request({"filter": "array", "page":"int"})
     */
    public function downloadAction($filter = null, $page = 1)
    {
        return [
            '$view' => [
                'title' => __('Downloads'),
                'name'  => 'bixie/download:views/admin/download.php'
            ],
            '$data' => [
                'config'   => [
                    'filter' => $filter,
                    'page'   => $page
                ]
            ]
        ];
    }

    /**
     * @Route("/file/edit", name="file/edit")
     * @Access("download: manage downloads")
     * @Request({"id": "int"})
     */
    public function editAction($id = 0)
    {
        try {

            if (!$file = File::where(compact('id'))->first()) {

                if ($id) {
                    App::abort(404, __('Invalid file id.'));
                }

				$module = App::module('bixie/download');

				$file = File::create([
					'slug' => '',
					'data' => [],
					'tags' => [],
					'date' => new \DateTime()
				]);

				$file->set('markdown', $module->config('markdown'));

			}


            return [
                '$view' => [
                    'title' => $id ? __('Edit download') : __('Add download'),
                    'name'  => 'bixie/download:views/admin/file.php'
                ],
                '$data' => [
					'config' => App::module('bixie/download')->config(),
                	'file'  => $file,
                    'tags'     => File::allTags()
                ],
                'file' => $file
            ];

        } catch (\Exception $e) {

            App::message()->error($e->getMessage());

            return App::redirect('@download/download');
        }
    }

    /**
     * @Access("system: manage settings")
     */
    public function settingsAction()
    {
        return [
            '$view' => [
                'title' => __('Download Settings'),
                'name'  => 'bixie/download:views/admin/settings.php'
            ],
            '$data' => [
                'config' => App::module('bixie/download')->config(),
                'tags'     => File::allTags()
           ]
        ];
    }
}
