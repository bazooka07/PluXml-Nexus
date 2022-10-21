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
     * @return array
     */
    static public function getAllPlugins(ContainerInterface $container, string $username = NULL)
    {
        if (isset($username)) {
            $userModel = UsersFacade::searchUser($container, $username);
            $pluginsModel = new PluginsModel($container, $userModel->id);
        } else {
            $pluginsModel = new PluginsModel($container);
        }

        return self::populatePluginsList($container, $pluginsModel);
    }

    /**
     * @param ContainerInterface $container
     * @param String $name
     * @return mixed
     */
    static public function getPlugin(ContainerInterface $container, string $name)
    {
        $pluginModel = new PluginModel($container, $name);

        if (empty($pluginModel->name)) {
            return false;
        }

        $category = CategoriesFacade::getPluginCategory($container, $pluginModel->category);
        return [
            'id' => $pluginModel->id,
            'title' => "Plugin $pluginModel->name Ressources - PluXml.org",
            'name' => $pluginModel->name,
            'description' => $pluginModel->description,
            'versionPlugin' => $pluginModel->versionPlugin,
            'versionPluxml' => $pluginModel->versionPluxml,
            'link' => $pluginModel->link,
            'file' => $pluginModel->file,
            'author' => Facade::getAuthorUsernameById($container, $pluginModel->author),
            'category' => $category->id,
            'categoryName' => $category->name,
            'categoryIcon' => $category->icon,
        ];
    }

    /**
     *
     * @param ContainerInterface $container
     * @param array $plugin
     * @return bool
     */
    static public function editPlugin(ContainerInterface $container, array $plugin)
    {
        $newPluginModel = new NewPluginModel($container, $plugin);
        return $newPluginModel->updatePlugin();
    }

    /**
     * @param ContainerInterface $container
     * @param array $plugin
     * @return bool
     */
    static public function savePlugin(ContainerInterface $container, array $plugin)
    {
        $newPluginModel = new NewPluginModel($container, $plugin);
        return $newPluginModel->saveNewPlugin();
    }

    /**
     * @param ContainerInterface $container
     * @param string $name
     * @return bool
     */
    static public function deletePlugin(ContainerInterface $container, string $name)
    {
        $pluginModel = new PluginModel($container, $name);
        $pluginModel->delete($container, $name) != false;
        return unlink(PUBLIC_DIR . DIR_PLUGINS . DIRECTORY_SEPARATOR . $name . '.zip'); # !!! dans model
    }

    static public function populatePluginsList(ContainerInterface $container, PluginsModel $pluginsModel)
    {
        $plugins = [];

        if (!empty($pluginsModel)) {
            foreach ($pluginsModel->plugins as $key => $value) {
                $plugins[] = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'author' => Facade::getAuthorUsernameById($container, $value['author']),
                    'versionPlugin' => $value['versionplugin'],
                    'versionPluxml' => $value['versionpluxml'],
                    'link' => $value['link'],
                    'file' => $value['file'],
                    'categoryName' => CategoriesFacade::getPluginCategory($container, $value['category'])->name,
                    'categoryIcon' => CategoriesFacade::getPluginCategory($container, $value['category'])->icon,
                ];
            }
        }

        return $plugins;
    }
}
