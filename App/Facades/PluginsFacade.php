<?php

namespace App\Facades;

use App\Models\CategoriesModel;
use App\Models\CategoryModel;
use Psr\Container\ContainerInterface;
use App\Models\PluginsModel;
use App\Models\PluginModel;
use App\Models\NewPluginModel;

/**
 * Class PluginsFacade
 * @package App\Facades
 */
class PluginsFacade extends Facade
{

    /**
     *
     * @param ContainerInterface $container
     * @param string|null $username
     * @param int $author
     * @return array
     */
    static public function getAllItems(ContainerInterface $container, int $author= NULL)
    {
        $collection = new PluginsModel($container, $author);
        return self::populate($container, $collection);
    }

    /**
     * @param ContainerInterface $container
     * @param String $name
     * @param int $author
     * @return mixed
     */
    static public function getItem(ContainerInterface $container, String $name, int $author)
    {
        $item = new PluginModel($container, $name, $author);

        if (!empty($item->id)) {
            return [
                'id' => $item->id,
                'title' => "Plugin $item->name Ressources - PluXml.org",
                'name' => $item->name,
                'description' => $item->description,
                'version' => $item->version,
                'pluxml' => $item->pluxml,
                'date' => $item->date,
                'link' => $item->link,
                'file' => $item->file,
                'media' => $item->media,
                'author' => $item->author,
                'username' => $item->username,
                'category' => $item->category,
                'categoryName' => $item->categoryName,
                'categoryIcon' => $item->categoryIcon,
            ];
        }

        return false;
    }

    /**
     *
     * @param ContainerInterface $container
     * @param array $datas
     * @return bool
     */
    static public function editItem(ContainerInterface $container, array $datas)
    {
        $newItem = new NewPluginModel($container, $datas);
        return $newItem->update();
    }

    /**
     * @param ContainerInterface $container
     * @param array $datas
     * @return bool
     */
    static public function saveItem(ContainerInterface $container, array $datas)
    {
        $newItem = new NewPluginModel($container, $datas);
        return $newItem->save();
    }

    /**
     * @param ContainerInterface $container
     * @param int $author id
     * @param string $name
     * @return bool
     */
    static public function deleteItem(ContainerInterface $container, int $author, string $name)
    {
        $item = new PluginModel($container, $author, $name);
        return $item->delete();
    }

    static public function populate(ContainerInterface $container, PluginsModel $collection)
    {
        if (!empty($collection->plugins)) {
            return $collection->plugins;
        }

        return [];
    }
}
