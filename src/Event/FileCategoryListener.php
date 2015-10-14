<?php

namespace Bixie\Download\Event;

use Pagekit\Application as App;
use Pagekit\Event\EventSubscriberInterface;
use Bixie\Download\Model\Category;
use Pagekit\Site\Model\Node;

class FileCategoryListener implements EventSubscriberInterface
{
    /**
     * Registers node routes
     */
    public function onRequest()
    {

        $categories     = Category::findAll(true);

        uasort($categories, function($a, $b) {
            return strcmp(substr_count($a->path, '/'), substr_count($b->path, '/')) * -1;
        });

		$node = Node::query()->where(['link' => '@download'])->first();
		//add root
		App::routes()->add([
			'name' => '@download/file/category/0',
			'label' => 'root',
			'defaults' => [
				'_node' => $node->id,
				'category_id' => 0
			],
			'path' => $node->path,
			'controller' => 'Bixie\\Download\\Controller\\SiteController::fileAction'
		]);

        foreach ($categories as $category) {

            if ($category->status !== 1) {
                continue;
            }

            $type = [
				'name' => '@download/file/category/' . $category->id,
				'label' => $category->title,
				'defaults' => [
					'_node' => $node->id,
					'category_id' => $category->id
				],
				'path' => $node->path . $category->path,
				'controller' => 'Bixie\\Download\\Controller\\SiteController::fileAction'
			];

			App::routes()->add($type);

        }

    }

    public function onNodeInit($event, $node)
    {
        if ('link' === $node->type && $node->get('redirect')) {
            $node->link = $node->path;
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
            'enable' => 'onEnable',
            'model.node.init' => 'onNodeInit',
            'model.role.deleted' => 'onRoleDelete'
        ];
    }
}
