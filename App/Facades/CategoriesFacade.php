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
        $categoryModel = self::getCategoryIdFromName($container, $categoryName);
        $pluginsModel = new PluginsModel($container, null, $categoryModel->id);
        return PluginsFacade::populatePluginsList($container, $pluginsModel);
    }

    /**
     * @param ContainerInterface $container
     * @param int $categoryId
     * @return CategoryModel
     */
    static public function getPluginCategory(ContainerInterface $container, int $categoryId)
    {
        return new CategoryModel($container, $categoryId);
    }

    static private function getCategoryIdFromName(ContainerInterface $container, string $categoryName) {
        return new CategoryModel($container, null, $categoryName);
    }
}