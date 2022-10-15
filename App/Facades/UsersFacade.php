<?php

namespace App\Facades;

use Psr\Container\ContainerInterface;
use App\Models\UsersModel;
use App\Models\UserModel;
use App\Models\PluginsModel;
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
    static public function getAllProfiles(ContainerInterface $container, bool $hadPlugins = false): array
    {
        $datas = [];
        $usersModel = new UsersModel($container, $hadPlugins);

        $datas['profiles'] = $usersModel->users;

        return $datas;
    }

    static public function getAllProfilesWithAndWithoutPlugins(ContainerInterface $container): array
    {
        $datas = UsersFacade::getAllProfiles($container);

        $usersWithPluginsModel = new UsersModel($container, true);
        $usersWithPlugins = $usersWithPluginsModel->users;

        foreach ($datas['profiles'] as $key => $profile)
        {
            $datas['profiles'][$key]['hadPlugins'] = false;
            foreach ($usersWithPlugins as $user => $profileWithPlugins)
            {
                if (in_array($profile['id'], $profileWithPlugins))
                {
                    $datas['profiles'][$key]['hadPlugins'] = true;
                }
            }
        }

        return $datas;
    }
    /**
     *
     * @param ContainerInterface $container
     * @param string $username
     * @param bool $withPlugins add user's plugins name to the view datas
     * @return array $datas
     */
    static public function getProfile(ContainerInterface $container, string $username, bool $withPlugins = false): array
    {
        $userModel = self::searchUser($container, $username);

        $datas = [
            'title' => "Profile $userModel->username Ressources - PluXml.org",
            'username' => $userModel->username,
            'userid' => $userModel->id,
            'email' => $userModel->email,
            'website' => $userModel->website,
        ];

        if ($withPlugins) {
            $datas['plugins'] = self::getPluginsByProfile($container, $userModel->id);
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
        foreach ($userModels->users as $k => $v)
            if (in_array($search, $v)) {
                $userId = $userModels->users[$k]['id'];
                break;
            }

        if (!empty($userId)) {
            $userModel = new UserModel($container, $userId);
        }

        return $userModel;
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
        $userModel = self::searchUser($container, $username);
        return $userModel->delete();
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
}
