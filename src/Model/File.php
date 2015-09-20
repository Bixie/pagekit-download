<?php

namespace Bixie\Download\Model;

use Pagekit\Application as App;
use Pagekit\System\Model\DataModelTrait;

/**
 * @Entity(tableClass="@download_file")
 */
class File implements \JsonSerializable
{
    use  DataModelTrait, FileModelTrait;

    /** @Column(type="integer") @Id */
    public $id;

    /** @Column(type="string") */
    public $slug;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="string") */
    public $path;

	/** @Column(type="text") */
    public $content = '';

	/** @Column(type="datetime") */
	public $date;

	/** @Column(type="simple_array") */
	public $tags;

	/** @Column(type="json_array") */
	public $image;

	public static function allTags () {
		//todo cache this
		$tags = [];
		foreach (self::findAll() as $file) {
			if (is_array($file->tags)) {
				$tags = array_merge($tags, $file->tags);
			}
		}
		$tags = array_unique($tags);
		natsort($tags);
		return $tags;
	}

	public static function getPrevious ($file) {
		return self::where(['date > ?'], [$file->date])->orderBy('date', 'ASC')->first();
	}

	public static function getNext ($file) {
		return self::where(['date < ?'], [$file->date])->orderBy('date', 'DESC')->first();
	}
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $data = [
            'url' => App::url('@download/id', ['id' => $this->id ?: 0], 'base')
        ];

        return $this->toArray($data);
    }
}
