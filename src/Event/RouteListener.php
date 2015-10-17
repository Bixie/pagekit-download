<?php

namespace Bixie\Download\Event;

use Pagekit\Application as App;
use Bixie\Download\FileUrlResolver;
use Bixie\Download\CategoryUrlResolver;
use Pagekit\Event\EventSubscriberInterface;

class RouteListener implements EventSubscriberInterface
{

    /**
     * Registers permalink route alias.
     */
    public function onConfigureRoute($event, $route)
    {
		$name = $route->getName();
		if ($name == '@download/id') {
			App::routes()->alias(dirname($route->getPath()) . '/{slug}', '@download/id', ['_resolver' => 'Bixie\Download\FileUrlResolver']);
        }
		if (stripos($name, '@download/category/file/') === 0) {
			App::routes()->alias($route->getPath().'/{slug}', $name, ['_resolver' => 'Bixie\Download\CategoryUrlResolver']);
        }
        if ($name == '@download/file/id') {
            App::routes()->alias(dirname($route->getPath()).'/{slug}', '@download/file/id', ['_resolver' => 'Bixie\Download\FileUrlResolver']);
        }
    }

    /**
     * Clears resolver cache.
     */
    public function clearCache()
    {
		App::cache()->delete(FileUrlResolver::CACHE_KEY);
		App::cache()->delete(CategoryUrlResolver::CACHE_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'route.configure' => 'onConfigureRoute',
            'model.project.saved' => 'clearCache',
            'model.project.deleted' => 'clearCache',
            'model.category.saved' => 'clearCache',
            'model.category.deleted' => 'clearCache'
        ];
    }
}
