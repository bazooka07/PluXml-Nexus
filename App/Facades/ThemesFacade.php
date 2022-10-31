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
    static public function getAllThemes(ContainerInterface $container, String $userid = NULL)
    {
        $themesModel = new ThemesModel($container, $userid);
        return self::populateThemesList($container, $themesModel);
    }

    static public function getTheme(ContainerInterface $container, String $name)
    {
        $themeModel = new ThemeModel($container, $name);

        if (empty($themeModel->name)) {
            return false;
        }

        return [
            'id' => $themeModel->id,
            'title' => "Theme $themeModel->name Ressources - PluXml.org",
            'name' => $themeModel->name,
            'description' => $themeModel->description,
            'version' => $themeModel->version,
            'pluxml' => $themeModel->pluxml,
            'date' => $themeModel->date,
            'link' => $themeModel->link,
            'file' => $themeModel->file,
            'media' => $themeModel->media,
            'authorid' => $themeModel->author,
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
        return unlink(PUBLIC_DIR . $themeModel->file);
    }

    static public function populateThemesList(ContainerInterface $container, ThemesModel $themesModel)
    {
        $themes = [];

        if (!empty($themesModel)) {
            foreach ($themesModel->themes as $infos) {
                $themes[] = [
                    'id' => $infos['id'],
                    'name' => $infos['name'],
                    'description' => $infos['description'],
                    'username' => isset($infos['username']) ? $infos['username'] : '',
                    'author' => $infos['author'],
                    'version' => $infos['version'],
                    'pluxml' => $infos['pluxml'],
                    'date' => $infos['date'],
                    'link' => $infos['link'],
                    'file' => $infos['file'],
                    'media' => $infos['media'],
                ];
            }
        }

        return $themes;
    }
}
