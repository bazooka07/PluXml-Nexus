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
            'title' => ucfirst(_['CONTRIBUTORS']),
            'h2' => _['CONTRIBUTORS'],
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
            $datas['categories'] = CategoriesFacade::getCategories($container, false, $userModel->id);
            if (isset($_SESSION['role']) and $_SESSION['role'] == 'admin')
            {
                if (preg_match('#/backoffice/users$#', $_SERVER['HTTP_REFERER'])) {
                    $datas['frombackoffice'] = true;
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
    static public function getProfileByToken(ContainerInterface $container, string $token): array
    {
        $userModel = new UserModel($container, $token);

        if(!empty($userModel->id)) {
            return [
                'title' => "Profile $userModel->username Ressources - PluXml.org",
                'username' => $userModel->username,
                'userid' => $userModel->id,
                'email' => $userModel->email,
                'website' => $userModel->website,
            ];
        }

        return false;
    }

    /**
     *
     * @param ContainerInterface $container
     * @param string $search
     * @return UserModel
     */
    static public function searchUser(ContainerInterface $container, string $username, bool $all=false): ?UserModel
    {
        $userModel = new UserModel($container, $username, '', $all);

        if(empty($userModel->id)) {
            return NULL;
        }

        return $userModel;
    }

    /**
     *
     * @param ContainerInterface $container
     * @param string $search
     * @return Array
     */
    static public function searchUsersByNameOrEmail(ContainerInterface $container, String $username, String $email)
    {
        $query = <<< EOT
select username, email
    from users
    where username='$username'
    or email='$email';
EOT;
        $usersModel = new UsersModel($container, UsersFilter::Extra, $query);

        $result = [];
        foreach($usersModel->users as $user) {
            if($user['username'] == $username) {
                $result['username'] = true;
            }
            if($user['email'] == $email) {
                $result['email'] = true;
            }
        }
        return array_keys($result);
    }

    /**
     *
     * @param ContainerInterface $container
     * @param string $search
     * @return UserModel
     */
    static public function searchUserWithValidToken(ContainerInterface $container, string $username): ?UserModel
    {

        return new UserModel($container, $username, '', true);
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
     * @param string $userid
     * @return bool
     */
    static public function removeUser(ContainerInterface $container, string $userid): bool
    {
        return UsersModel::removeUserById($container, $userid);
    }

    /**
     * @param ContainerInterface $container
     * @return integer|false
     */
    static public function removeExpire(ContainerInterface $container)
    {
        return UsersModel::removeExpiredUsers($container);
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
        return isset($pluginsModel) ? PluginsFacade::populate($container, $pluginsModel) : null;
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
        return isset($themesModel) ? ThemesFacade::populate($container, $themesModel) : null;
    }

}
