<?php

namespace Bixie\Download\Controller;

use Pagekit\Application as App;
use Bixie\Download\Model\File;

/**
 * @Access("download: manage downloads")
 * @Route("file", name="file")
 */
class FileApiController
{
    /**
     * @Route("/", methods="GET")
     * @Request({"filter": "array", "page":"int"})
     */
    public function indexAction($filter = [], $page = 0)
    {
        $query  = File::query();
        $filter = array_merge(array_fill_keys(['search', 'order', 'limit'], ''), $filter);

        extract($filter, EXTR_SKIP);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->orWhere(['title LIKE :search'], ['search' => "%{$search}%"]);
            });
        }


        if (!preg_match('/^(date|title)\s(asc|desc)$/i', $order, $order)) {
            $order = [1 => 'date', 2 => 'desc'];
        }

        $limit = (int) $limit ?: App::module('bixie/download')->config('files_per_page');
        $count = $query->count();
        $pages = ceil($count / $limit);
        $page  = max(0, min($pages - 1, $page));

        $files = array_values($query->offset($page * $limit)->limit($limit)->orderBy($order[1], $order[2])->get());

        return compact('files', 'pages', 'count');
    }

    /**
     * @Route("/{id}", methods="GET", requirements={"id"="\d+"})
     */
    public function getAction($id)
    {
        return File::where(compact('id'))->first();
    }

    /**
     * @Route("/", methods="POST")
     * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
     * @Request({"file": "array", "id": "int"}, csrf=true)
     */
    public function saveAction($data, $id = 0)
    {
        if (!$id || !$file = File::find($id)) {

            if ($id) {
                App::abort(404, __('Post not found.'));
            }

			$file = File::create();
        }

        if (!$data['slug'] = App::filter($data['slug'] ?: $data['title'], 'slugify')) {
            App::abort(400, __('Invalid slug.'));
        }


		$file->save($data);

        return ['message' => 'success', 'file' => $file];
    }

    /**
     * @Route("/{id}", methods="DELETE", requirements={"id"="\d+"})
     * @Request({"id": "int"}, csrf=true)
     */
    public function deleteAction($id)
    {
        if ($project = File::find($id)) {

            if(!App::user()->hasAccess('download: manage downloads')) {
                return ['error' => __('Access denied.')];
            }

			$project->delete();
        }

        return ['message' => 'success'];
    }

    /**
     * @Route("/bulk", methods="POST")
     * @Request({"files": "array"}, csrf=true)
     */
    public function bulkSaveAction($files = [])
    {
        foreach ($files as $data) {
            $this->saveAction($data, isset($data['id']) ? $data['id'] : 0);
        }

        return ['message' => 'success'];
    }

    /**
     * @Route("/bulk", methods="DELETE")
     * @Request({"ids": "array"}, csrf=true)
     */
    public function bulkDeleteAction($ids = [])
    {
        foreach (array_filter($ids) as $id) {
            $this->deleteAction($id);
        }

        return ['message' => 'success'];
    }
}
