<?php

namespace Bixie\Download\Controller;

use Pagekit\Application as App;
use Bixie\Download\Model\Category;

/**
 * @Access("download: manage categories")
 * @Route("category", name="category")
 */
class CategoryApiController
{
    /**
     * @Route("/", methods="GET")
     * @Request({"menu"})
     */
    public function indexAction($root = false)
    {
        $query = Category::query();

        if (is_numeric($root)) {
            $query->where(['parent_id' => $root]);
        }

        return array_values($query->related('files')->get());
    }

    /**
     * @Route("/{id}", methods="GET", requirements={"id"="\d+"})
     */
    public function getAction($id)
    {
        if (!$category = Category::find($id)) {
            App::abort(404, __('Category not found.'));
        }

        return $category;
    }

    /**
     * @Route("/", methods="POST")
     * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
     * @Request({"category": "array", "id": "int"}, csrf=true)
     */
    public function saveAction($data, $id = 0)
    {
        if (!$category = Category::where(compact('id'))->related('files')->first()) {
			$category = Category::create();
            unset($data['id']);
        }

        if (!$data['slug'] = App::filter($data['slug'] ?: $data['title'], 'slugify')) {
            App::abort(400, __('Invalid slug.'));
        }

		$category->updateOrdering($data);
		//unset array typed files
		unset($data['files']);

		$category->save($data);

        return ['message' => 'success', 'category' => $category];
    }

    /**
     * @Route("/{id}", methods="DELETE", requirements={"id"="\d+"})
     * @Request({"id": "int"}, csrf=true)
     */
    public function deleteAction($id)
    {
        if ($category = Category::find($id)) {

			$category->delete();
        }

        return ['message' => 'success'];
    }

    /**
     * @Route("/bulk", methods="POST")
     * @Request({"categories": "array"}, csrf=true)
     */
    public function bulkSaveAction($categories = [])
    {
        foreach ($categories as $data) {
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

    /**
     * @Route("/updateOrder", methods="POST")
     * @Request({"categories": "array"}, csrf=true)
     */
    public function updateOrderAction($categories = [])
    {
        foreach ($categories as $data) {

            if ($category = Category::find($data['id'])) {

				$category->priority  = $data['order'];
				$category->parent_id = $data['parent_id'] ?: 0;

				$category->save();
            }
        }

        return ['message' => 'success'];
    }

}
