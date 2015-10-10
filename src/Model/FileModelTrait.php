<?php

namespace Bixie\Download\Model;

use Pagekit\Application as App;
use Pagekit\Database\ORM\ModelTrait;

trait FileModelTrait
{
    use ModelTrait;

    /**
     * @Saving
     */
    public static function saving($event, File $file)
    {
		//slug
        $i  = 2;
        $id = $file->id;

        while (self::where('slug = ?', [$file->slug])->where(function ($query) use ($id) {
            if ($id) {
                $query->where('id <> ?', [$id]);
            }
        })->first()) {
			$file->slug = preg_replace('/-\d+$/', '', $file->slug).'-'.$i++;
        }

    }

}
