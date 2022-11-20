<?php

namespace App\Facades;

use App\Models\CategoriesModel;
use App\Models\CategoryModel;
use Psr\Container\ContainerInterface;
use App\Models\PluginsModel;

/**
 * Class CategoriesFacade
 * @package App\Facades
 */
class CategoriesFacade extends Facade
{

    /**
     * @param ContainerInterface $container
     * @return array
     */
    static public function getCategories(ContainerInterface $container, bool $all=false)
    {
        $categoriesModel = new CategoriesModel($container, $all);
        return $categoriesModel->categories;
    }

    static public function getPluginsForCategory(ContainerInterface $container, string $categoryName)
    {
        $pluginsModel = new PluginsModel($container, null, null, $categoryName);
        return PluginsFacade::populate($container, $pluginsModel);
    }

    /**
     * Deprecated! see SQL query
     * @param ContainerInterface $container
     * @param int $categoryId
     * @return CategoryModel
     */
    static public function getPluginCategory(ContainerInterface $container, int $categoryId)
    {
        return new CategoryModel($container, $categoryId);
    }

    /**
     * Deprecated! see SQL query
     */
    static private function getCategoryIdFromName(ContainerInterface $container, string $categoryName) {
        return new CategoryModel($container, null, $categoryName);
    }
}
