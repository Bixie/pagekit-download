<?php

namespace Bixie\Download\Model;

use Pagekit\Application as App;
use Pagekit\Database\ORM\ModelTrait;

trait CategoryModelTrait
{
    use ModelTrait {
        find as modelFind;
    }

    protected static $categories;

    /**
     * Retrieves an entity by its identifier.
     *
     * @param  mixed $id
     * @param  bool  $cached
     * @return static
     */
    public static function find($id, $cached = false)
    {
        if (!$cached || !isset(self::$categories[$id])) {
            self::$categories[$id] = self::modelFind($id);
        }

        return self::$categories[$id];
    }

    /**
     * Retrieves all entities.
     *
     * @param  bool $cached
     * @return static[]
     */
    public static function findAll($cached = false)
    {
        if (!$cached || null === self::$categories) {
            self::$categories = self::query()->orderBy('priority')->get();
        }

        return self::$categories;
    }

    /**
     * Retrieves all nodes by root.
     *
     * @return static[]
     */
    public static function findByRoot($root, $cached = false)
    {
        return array_filter(self::findAll($cached), function ($node) use ($root) { return $root == $node->parent_id; });
    }

    /**
     * Sets parent_id of orphaned nodes to zero.
     *
     * @return int
     */
    public static function fixOrphanedCategories()
    {
        if ($orphaned = self::getConnection()
            ->createQueryBuilder()
            ->from(self::getMetadata()->getTable().' n')
            ->leftJoin(self::getMetadata()->getTable().' c', 'c.id = n.parent_id')
            ->where(['n.parent_id <> 0', 'c.id IS NULL'])
            ->execute('n.id')->fetchAll(\PDO::FETCH_COLUMN)
        ) {
            return self::query()
                ->whereIn('id', $orphaned)
                ->update(['parent_id' => 0]);
        }

        return 0;
    }

    /**
     * @Saving
     */
    public static function saving($event, Category $category)
    {
        $db = self::getConnection();

        $i = 2;
        $id = $category->id;

        if (!$category->slug) {
            $category->slug = $category->title;
        }

        // Ensure unique slug
        while (self::where(['slug = ?', 'parent_id= ?'], [$category->slug, $category->parent_id])->where(function ($query) use ($id) {
            if ($id) $query->where('id <> ?', [$id]);
        })->first()) {
            $category->slug = preg_replace('/-\d+$/', '', $category->slug).'-'.$i++;
        }

        // Update own path
        $path = '/'.$category->slug;
        if ($category->parent_id && $parent = Category::find($category->parent_id)) {
            $path = $parent->path.$path;
        } else {
            // set Parent to 0, if old parent is not found
            $category->parent_id = 0;
        }

        // Update children's paths
        if ($id && $path != $category->path) {
            $db->executeUpdate(
                'UPDATE '.self::getMetadata()->getTable()
                .' SET path = REPLACE ('.$db->getDatabasePlatform()->getConcatExpression($db->quote('//'), 'path').", '//{$category->path}', '{$path}')"
                .' WHERE path LIKE '.$db->quote($category->path.'//%'));
        }

        $category->path = $path;

        // Set priority
        if (!$id) {
            $category->priority = 1 + $db->createQueryBuilder()
                    ->select($db->getDatabasePlatform()->getMaxExpression('priority'))
                    ->from(self::getMetadata()->getTable())
                    ->where(['parent_id' => $category->parent_id])
                    ->execute()
                    ->fetchColumn();
        }


    }

    /**
     * @Deleting
     */
    public static function deleting($event, Category $category)
    {
        // Update children's parents
        foreach (self::where('parent_id = ?', [$category->id])->get() as $child) {
            $child->parent_id = $category->parent_id;
            $child->save();
        }
    }
}
