<?php

use Bixie\Download\Model\File;

return [

    'name' => 'bixie/downloads',

    'label' => 'Downloads',

    'events' => [

        'view.scripts' => function ($event, $scripts) use ($app) {
            $scripts->register('widget-downloads', 'bixie/download:app/bundle/widget-downloads.js', ['~widgets']);
        }

    ],

    'render' => function ($widget) use ($app) {
		$files = File::where(['status = :status'], ['status' => File::STATUS_PUBLISHED])->get();
		$view = $widget->get('view', 'list');

		return $app['view']('bixie/download/widgets/downloads-'.$view.'.php', compact('widget', 'files'));
    }

];
