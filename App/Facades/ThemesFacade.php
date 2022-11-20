<?php

namespace App\Facades;

use Psr\Container\ContainerInterface;
use App\Models\ThemesModel;
use App\Models\ThemeModel;
use App\Models\NewThemeModel;

/**
 * Class ThemesFacade
 * @package App\Facades
 */
class ThemesFacade extends Facade
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
        $collection = new ThemesModel($container, $author);
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
        $item = new ThemeModel($container, $name, $author);

        if (!empty($item->id)) {
            return [
                'id' => $item->id,
                'title' => "Theme $item->name Ressources - PluXml.org",
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
        $newItem = new NewThemeModel($container, $datas);
        return $newItem->update();
    }

    /**
     * @param ContainerInterface $container
     * @param array $datas
     * @return bool
     */
    static public function saveItem(ContainerInterface $container, array $datas)
    {
        $newItem = new NewThemeModel($container, $datas);
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
        $item = new ThemeModel($container, $author, $name);
        return $item->delete();
    }

    static public function populate(ContainerInterface $container, ThemesModel $collection)
    {
        if (!empty($collection->themes)) {
            return $collection->themes;
        }

        return [];
    }
}
