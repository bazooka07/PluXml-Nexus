<?php

namespace App\Facades;

use Psr\Container\ContainerInterface;
use App\Models\UsersFilter;
use App\Models\UsersModel;
use App\Models\UserModel;
use App\Models\PluginsModel;
use App\Models\ThemesModel;
use App\Models\NewUserModel;

/**
 * Class UsersFacade
 * @package App\Facades
 */
class UsersFacade
{

    /**
     *
     * @param ContainerInterface $container
     * @param bool $hadPlugins
     * @return array $datas
     */
    static public function getAllProfiles(ContainerInterface $container, UsersFilter $filter = UsersFilter::None): array
    {
        $usersModel = new UsersModel($container, $filter);
        return [
            'profiles'    => $usersModel->users,
            'expireCount' => $usersModel->expireCount(),
        ];
    }

    static public function getAllProfilesWithItemsCount(ContainerInterface $container): array
    {
        return UsersFacade::getAllProfiles($container, UsersFilter::ItemsCount);
    }

    /**
     *
     * @param ContainerInterface $container
     * @param string $username
     * @param bool $withPlugins add user's plugins name to the view datas
     * @return array $datas
     */
    static public function getProfile(ContainerInterface $container, string $username, bool $asContributor = false): array
    {
        $userModel = self::searchUser($container, $username);

        $datas = [
            'title' => "Profile $userModel->username Ressources - PluXml.org",
            'username' => $userModel->username,
            'userid' => $userModel->id,
            'email' => $userModel->email,
            'website' => $userModel->website,
        ];

        if ($asContributor) {
            $datas['plugins'] = self::getPluginsByProfile($container, $userModel->id);
            $datas['themes'] = self::getThemesByProfile($container, $userModel->id);
        }

        return $datas;
    }

    /**
     *
     * @param ContainerInterface $container
     * @param string $search
     * @return UserModel
     */
    static public function searchUser(ContainerInterface $container, string $search): ?UserModel
    {
        $userModel = NULL;
        $userModels = new UsersModel($container);

        // Search userid by the username
        $rows = array_filter($userModels->users, function($userInfos) use($search) {
            return ($userInfos['username'] === $search and empty($userInfos['token']));
        });

        if(count($rows) !== 1) {
            return NULL;
        }

        return new UserModel($container, array_values($rows)[0]['id']);
    }

    /**
     * @param ContainerInterface $container
     * @param array $user
     * @return bool
     */
    static public function addUser(ContainerInterface $container, array $user): bool
    {
        $newUserModel = new NewUserModel($container, $user);
        return $newUserModel->saveNewUser();
    }

    /**
     * @param ContainerInterface $container
     * @param array $user
     * @return bool
     */
    static public function editUser(ContainerInterface $container, array $user): bool
    {
        $newUserModel = new NewUserModel($container, $user);
        return $newUserModel->updateUser();
    }

    /**
     * @param ContainerInterface $container
     * @param string $username
     * @return bool
     */
    static public function removeUser(ContainerInterface $container, string $username): bool
    {
        return $userModel->delete();
    }

    /**
     * @param ContainerInterface $container
     * @param string $username
     * @return bool
     */
    static public function removeExpire(ContainerInterface $container): bool
    {
        $usersModel = new UsersModel($container, $hadPlugins);
        return $usersModel->expire();
    }

    /**
     *
     * @param ContainerInterface $container
     * @param string $userid
     * @return array|null
     */
    static private function getPluginsByProfile(ContainerInterface $container, string $userid): ?array
    {
        $pluginsModel = new PluginsModel($container, $userid);
        return isset($pluginsModel) ? PluginsFacade::populatePluginsList($container, $pluginsModel) : null;
    }

    /**
     *
     * @param ContainerInterface $container
     * @param string $userid
     * @return array|null
     */
    static private function getThemesByProfile(ContainerInterface $container, string $userid): ?array
    {
        $themesModel = new ThemesModel($container, $userid);
        return isset($themesModel) ? ThemesFacade::populateThemesList($container, $themesModel) : null;
    }
}
