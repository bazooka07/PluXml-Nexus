<?php
/**
 * PluginsFacade
 */

namespace App\Facades;

use App\Models\UserModel;
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
        $result = FALSE;
        $userModel = UsersFacade::searchUser($container, $username);

        if (!empty($userModel) and !empty($userModel->role) and password_verify($password, $userModel->password)) {
            $result = TRUE;
            $_SESSION['user'] = $userModel->username;
            $_SESSION['role'] = $userModel->role;
        }

        return $result;
    }

    /**
     * Check if user is logged
     *
     * @return boolean
     */
    static public function isLogged(): bool
    {
        $result = FALSE;

        if (isset($_SESSION['user'])) {
            $result = TRUE;
        }

        return $result;
    }

    /**
     * Check user role from session and model
     *
     * @param ContainerInterface $container
     * @return boolean
     */
    static public function isAdmin(ContainerInterface $container, $username): bool
    {
        $result = FALSE;

        if ($_SESSION['role'] == 'admin') {
            $userModel = UsersFacade::searchUser($container, $username);
            if ($userModel->role == 'admin') {
                $result = TRUE;
            }
        }

        return $result;
    }

    /**
     * Logout the user
     */
    static public function logout()
    {
        unset($_SESSION['user']);
    }

    /**
     * @param ContainerInterface $container
     * @param String $username
     * @return mixed
     */
    static public function sendConfirmationEmail(ContainerInterface $container, string $username)
    {
        $userModel = UsersFacade::searchUser($container, $username);

        $host = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $tokenHref = $container->get('router')->urlFor('confirmEmail') . "?username=$userModel->username&token=$userModel->token";
        $placeholder = [
            '##USERNAME##' => $userModel->username,
            '##TOKEN##' => '<p><a href="' . $host . $tokenHref . '">' . $host . $tokenHref . '</a></p>',
            '##LIFETIME##' => AUTH_SIGNUP_LIFETIME,
        ];
        $body = strtr(MAIL_NEWUSER_BODY, $placeholder);

        $result = $container->get('mail')->sendMail(
            MAIL_FROM,
            MAIL_FROM_NAME,
            $userModel->email,
            $userModel->username,
            MAIL_NEWUSER_SUBJECT,
            $body,
            TRUE
        );

        return $result;
    }

    /**
     * @param ContainerInterface $container
     * @param String $username
     * @param String $token
     * @return bool
     */
    static public function confirmEmail(ContainerInterface $container, string $username, string $token): bool
    {
        $result = FALSE;

        $userModel = UsersFacade::searchUser($container, $username);

        if (isset($userModel->token) and isset($userModel->tokenExpire)) {
            if ($userModel->token == $token and $userModel->tokenExpire >= date('Y-m-d H:i:s')) {
                $userModel->role = 'user';
                $userModel->token = NULL;
                $userModel->tokenExpire = '0000-00-00 00:00:00';
                $userModel->editUser();
                $result = TRUE;
            }
        }

        return $result;
    }

    /**
     * @param ContainerInterface $container
     * @param String $username
     * @return bool
     */
    static public function sendNewPasswordEmail(ContainerInterface $container, string $username): bool
    {
        $result = FALSE;

        $userModel = UsersFacade::searchUser($container, $username);

        if (isset($userModel->id)) {
            $token = $userModel->generateToken();
            $userModel->token = $token['token'];
            $userModel->tokenExpire = $token['expire'];
            $result = $userModel->editUser();
        }

        if ($result) {
            $host = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
            $tokenHref = $container->get('router')->urlFor('resetPassword') . "?token=$userModel->token";
            $placeholder = [
                '##USERNAME##' => $userModel->username,
                '##URL_PASSWORD##' => $host . $tokenHref,
                '##URL_EXPIRY##' => $token['expire']
            ];
            $body = str_replace(array_keys($placeholder), array_values($placeholder), MAIL_LOSTPASSWORD);

            $result = $container->get('mail')->sendMail(MAIL_FROM, MAIL_FROM_NAME, $userModel->email, $userModel->username, MAIL_NEWUSER_SUBJECT, $body, TRUE);
        }

        return $result;
    }

    /**
     * @param ContainerInterface $container
     * @param String $token
     * @return bool
     */
    static public function confirmLostPasswordToken(ContainerInterface $container, string $token): bool
    {
        $result = false;
        if (isset($token)) {
            $userModel = UsersFacade::searchUser($container, $token);
            if (isset($userModel)) {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * @param ContainerInterface $container
     * @param string $username
     * @param string $password
     * @return bool
     */
    static public function resetPassword(ContainerInterface $container, string $username, string $password): bool
    {
        $result = FALSE;

        $userModel = UsersFacade::searchUser($container, $username);

        if (isset($userModel->token) and isset($userModel->tokenExpire)) {
            if ($userModel->tokenExpire >= date('Y-m-d H:i:s')) {
                $userModel->token = NULL;
                $userModel->tokenExpire = '0000-00-00 00:00:00';
                $userModel->password = password_hash($password, PASSWORD_BCRYPT);
                $userModel->editUser();
                $result = TRUE;
            }
        }

        return $result;
    }
}