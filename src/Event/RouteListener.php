<?php

namespace Bixie\Download\Event;

use Pagekit\Application as App;
use Bixie\Download\UrlResolver;
use Pagekit\Event\EventSubscriberInterface;

class RouteListener implements EventSubscriberInterface
{

    /**
     * Registers permalink route alias.
     */
    public function onConfigureRoute($event, $route)
    {
        if ($route->getName() == '@download/id') {
            App::routes()->alias(dirname($route->getPath()).'/{slug}', '@download/id', ['_resolver' => 'Bixie\Download\UrlResolver']);
        }
        if ($route->getName() == '@download/file/id') {
            App::routes()->alias(dirname($route->getPath()).'/{slug}', '@download/file/id', ['_resolver' => 'Bixie\Download\UrlResolver']);
        }
    }

    /**
     * Clears resolver cache.
     */
    public function clearCache()
    {
        App::cache()->delete(UrlResolver::CACHE_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'route.configure' => 'onConfigureRoute',
            'model.project.saved' => 'clearCache',
            'model.project.deleted' => 'clearCache'
        ];
    }
}
