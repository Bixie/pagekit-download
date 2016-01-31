<?php

namespace Bixie\Download\Controller;

use Bixie\Download\Model\Category;
use Pagekit\Application as App;
use Bixie\Download\Model\File;
use Pagekit\User\Model\Role;

/**
 * @Access(admin=true)
 */
class DownloadController
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
     * @Access("download: manage downloads")
     * @Request({"filter": "array", "page":"int"})
     */
    public function downloadAction($filter = null, $page = 0)
    {
        return [
            '$view' => [
                'title' => __('Downloads'),
                'name'  => 'bixie/download/admin/download.php'
            ],
            '$data' => [
				'categories' => Category::findAll(),
				'statuses' => File::getStatuses(),
				'config'   => [
                    'ordering' => $this->download->config('ordering'),
                    'ordering_dir' => $this->download->config('ordering_dir'),
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

            if (!$file = File::where(compact('id'))->related('categories')->first()) {

                if ($id) {
                    App::abort(404, __('Invalid file id.'));
                }


				$file = File::create([
					'status' => 1,
					'slug' => '',
					'data' => [],
					'tags' => [],
					'date' => new \DateTime()
				]);

				$file->set('markdown', $this->download->config('markdown'));

			}


            return [
                '$view' => [
                    'title' => $id ? __('Edit download') : __('Add download'),
                    'name'  => 'bixie/download/admin/file.php'
                ],
                '$data' => [
					'categories' => Category::findAll(),
					'statuses' => File::getStatuses(),
					'roles'    => array_values(Role::findAll()),
					'config' => $this->download->config(),
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
	 * @Route("categories", name="admin/categories")
	 * @Access("download: manage categories")
	 */
	public function categoriesAction()
	{

		if ($test = Category::fixOrphanedCategories()) {
			return App::redirect('@download/categories');
		}

		return [
			'$view' => [
				'title' => __('Categories'),
				'name'  => 'bixie/download/admin/categories.php'
			],
			'$data' => []
		];
	}

	/**
	 * @Route("category/edit", name="admin/category/edit")
	 * @Access("download: manage categories")
	 * @Request({"id": "int"})
	 */
	public function editCategoryAction($id = 0)
	{

		if (!$category = Category::where(compact('id'))->related('files')->first()) {

			if ($id) {
				App::abort(404, __('Invalid file id.'));
			}

			$category = Category::create([
				'status' => 1,
				'slug' => ''
			]);

			$category->set('markdown', $this->download->config('markdown'));

		}


		return [
			'$view' => [
				'title' => $id ? __('Edit category') : __('Add category'),
				'name'  => 'bixie/download/admin/category.php'
			],
			'$data' => [
				'roles'    => array_values(Role::findAll()),
				'category'  => $category
			],
			'category' => $category
		];

	}

	/**
     * @Access("system: manage settings")
     */
    public function settingsAction()
    {
        return [
            '$view' => [
                'title' => __('Download Settings'),
                'name'  => 'bixie/download/admin/settings.php'
            ],
            '$data' => [
                'config' => App::module('bixie/download')->config(),
                'tags'     => File::allTags()
           ]
        ];
    }

	/**
	 * @Access("system: manage settings")
	 * @Request({"config": "array"}, csrf=true)
	 */
	public function configAction($config = [])
	{
		App::config('bixie/download')->merge($config, true)->set('datafields', $config['datafields']);

		return ['message' => 'success'];
	}

}
