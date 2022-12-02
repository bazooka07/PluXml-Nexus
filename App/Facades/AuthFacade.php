<?php
/**
 * PluginsFacade
 */

namespace App\Facades;

use App\Models\UserModel;
use App\Models\UsersModel;
use Psr\Container\ContainerInterface;

/**
 * Class AuthFacade
 * @package App\Facades
 */
class AuthFacade extends Facade
{

    /**
     *
     * @param ContainerInterface $container
     * @param String $username
     * @param String $password
     * @return bool
     */
    static public function authentificateUser(ContainerInterface $container, string $username, string $password): bool
    {
        try{
            $userModel = new UserModel($container,  $username, $password);
            $_SESSION['user'] = $userModel->username;
            $_SESSION['userid'] = $userModel->id;
            $_SESSION['role'] = $userModel->role;
            $_SESSION['lastconnected'] = $userModel->lastconnected;
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    /**
     * Logout the user
     */
    static public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['userid']);
        unset($_SESSION['role']);
        unset($_SESSION['lastconnected']);
    }

    /**
     * Check if user is logged
     *
     * @return boolean
     */
    static public function isLogged(): bool
    {
        return (isset($_SESSION['user']));
    }

    /**
     * Check user role from session and model
     *
     * @param ContainerInterface $container
     * @return boolean
     */
    static public function isAdmin(ContainerInterface $container, $username): bool
    {
        if ($_SESSION['role'] !== 'admin') {
            return FALSE;
        }

        $userModel = UsersFacade::searchUser($container, $username);
        return !empty($userModel) ? $userModel->role == 'admin' : FALSE;
    }

    /**
     * @param ContainerInterface $container
     * @param String $username
     * @return mixed
     */
    static public function sendConfirmationEmail(ContainerInterface $container, string $username)
    {
        $userModel = UsersFacade::searchUserWithValidToken($container, $username, true);

        if ($userModel === null) {
            return false;
        }

        $host = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $tokenHref = $container->get('router')->urlFor('confirmEmail') . "?username=$userModel->username&token=$userModel->token";
        $placeholder = [
            '##USERNAME##' => $userModel->username,
            '##HREF##'  => $host,
            '##LINK##' => $host . $tokenHref,
            '##HOURS##' => AUTH_SIGNUP_LIFETIME,
        ];

        return $container->get('mail')->sendMail(
            MAIL_FROM,
            MAIL_FROM_NAME,
            $userModel->email,
            $userModel->username,
            MAIL_NEWUSER_SUBJECT,
            strtr(MAIL_NEWUSER_BODY, $placeholder), # body
            TRUE
        );
    }

    /**
     * @param ContainerInterface $container
     * @param String $username
     * @param String $token
     * @return bool
     */
    static public function confirmEmail(ContainerInterface $container, string $username, string $token): bool
    {
        return UsersModel::confirmEmail($container, $username, $token);
    }

    /**
     * @param ContainerInterface $container
     * @param String $username
     * @return bool
     */
    static public function sendNewPasswordEmail(ContainerInterface $container, string $username): bool
    {
        # vérifier que $userModel->token est vide
        $userModel = UsersFacade::searchUser($container, $username);

        if (!empty($userModel->id)) {
            if ($userModel->editUser(true)) {
                $host = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                $tokenHref = $container->get('router')->urlFor('resetPassword') . '?token=' . $userModel->token;
                $placeholder = [
                    '##USERNAME##' => $userModel->username,
                    '##HREF##'  => $host,
                    '##LINK##' => $host . $tokenHref,
                    '##HOURS##' => AUTH_SIGNUP_LIFETIME,
                ];

                return $container->get('mail')->sendMail(
                    MAIL_FROM,
                    MAIL_FROM_NAME,
                    $userModel->email,
                    $userModel->username,
                    MAIL_NEWUSER_SUBJECT,
                    strtr(MAIL_NEWUSER_BODY, $placeholder), # body
                    TRUE
                );
            }
        }

        return false;
    }

    /**
     * @param ContainerInterface $container
     * @param String $token
     * @return bool
     */
    static public function confirmLostPasswordToken(ContainerInterface $container, string $token): bool
    {
        if (isset($token)) {
            $userModel = new UserModel($container, $token);
            if (!empty($userModel->id)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param ContainerInterface $container
     * @param string $username
     * @param string $password
     * @return bool
     */
    static public function resetPassword(ContainerInterface $container, string $username, string $password): bool
    {
        $userModel = UsersFacade::searchUser($container, $username, true);

        if (!empty($userModel->id)) {
            $userModel->password = $password;
            return $userModel->editUser();
        }

        return false;
    }
}