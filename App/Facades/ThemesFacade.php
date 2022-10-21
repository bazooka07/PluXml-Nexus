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
     * @return array
     */
    static public function getAllThemes(ContainerInterface $container, String $username = NULL)
    {
        if (isset($username)) {
            $userModel = UsersFacade::searchUser($container, $username);
            $themesModel = new ThemesModel($container, $userModel->id);
        } else {
            $themesModel = new ThemesModel($container);
        }

        return self::populateThemesList($container, $themesModel);
    }

    static public function getTheme(ContainerInterface $container, String $name)
    {
        $themeModel = new ThemeModel($container, $name);

        if (empty($themeModel->name)) {
            return false;
        }

        return [
            'title' => "Theme $themeModel->name Ressources - PluXml.org",
            'name' => $themeModel->name,
            'description' => $themeModel->description,
            'versionTheme' => $themeModel->versionTheme,
            'versionPluxml' => $themeModel->versionPluxml,
            'link' => $themeModel->link,
            'file' => $themeModel->file,
            'author' => Facade::getAuthorUsernameById($container, $themeModel->author),
        ];
    }

    /**
     *
     * @param ContainerInterface $container
     * @param array $plugin
     * @return bool
     */
    static public function editTheme(ContainerInterface $container, array $theme)
    {
        $newThemeModel = new NewThemeModel($container, $theme);
        return $newThemeModel->updateTheme();
    }

    /**
     * @param ContainerInterface $container
     * @param array $theme
     * @return bool
     */
    static public function saveTheme(ContainerInterface $container, array $theme)
    {
        $newThemeModel = new NewThemeModel($container, $theme);
        return $newThemeModel->saveNewTheme();
    }

    /**
     * @param ContainerInterface $container
     * @param string $name
     * @return bool
     */
    static public function deleteTheme(ContainerInterface $container, string $name)
    {
        $themeModel = new ThemeModel($container, $name);
        $themeModel->delete($container, $name) != false;
        return unlink(PUBLIC_DIR . DIR_THEMES . DIRECTORY_SEPARATOR . $name . '.zip'); # !!! dans model
    }

    static public function populateThemesList(ContainerInterface $container, ThemesModel $themesModel)
    {
        $themes = [];

        if (!empty($themesModel)) {
            foreach ($themesModel->themes as $key => $value) {
                $themes[] = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'author' => Facade::getAuthorUsernameById($container, $value['author']),
                    'versionTheme' => $value['versiontheme'],
                    'versionPluxml' => $value['versionpluxml'],
                    'link' => $value['link'],
                    'file' => $value['file'],
                ];
            }
        }

        return $themes;
    }
}
