<?php

namespace Bixie\Download\Event;

use Pagekit\Application as App;
use Pagekit\Event\EventSubscriberInterface;
use Bixie\Download\Model\File;

class FileListener implements EventSubscriberInterface
{

    public function onRoleDelete($event, $role)
    {
		File::removeRole($role);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'model.role.deleted' => 'onRoleDelete'
        ];
    }
}
