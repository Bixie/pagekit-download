<?php

namespace Bixie\Download\Event;

use Pagekit\Application as App;
use Pagekit\Event\EventSubscriberInterface;
use Bixie\Download\Model\Category;
use Pagekit\Site\Model\Node;

class CategoryListener implements EventSubscriberInterface
{
    /**
     * Registers category routes
     */
    public function onRequest()
    {

        $categories     = Category::findAll(true);

        uasort($categories, function($a, $b) {
            return strcmp(substr_count($a->path, '/'), substr_count($b->path, '/')) * -1;
        });

		$node = Node::query()->where(['link' => '@download'])->first();

        foreach ($categories as $category) {

            if ($category->status !== 1) {
                continue;
            }
			$route = [
				'label' => $category->title,
				'defaults' => [
					'_node' => $node->id,
					'id' => $category->id
				],
				'path' => $node->path . $category->path,
			];
			//category views
			App::routes()->add(array_merge([
				'name' => '@download/category/' . $category->id,
				'controller' => 'Bixie\\Download\\Controller\\SiteController::categoryAction'
			], $route));

			//file view
			App::routes()->add(array_merge([
				'name' => '@download/category/file/' . $category->id,
				'controller' => 'Bixie\\Download\\Controller\\SiteController::fileAction'
			], $route));

        }

    }

    public function onRoleDelete($event, $role)
    {
		Category::removeRole($role);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'request' => ['onRequest', 120],
            'model.role.deleted' => 'onRoleDelete'
        ];
    }
}
