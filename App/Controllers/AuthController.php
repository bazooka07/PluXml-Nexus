<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Facades\AuthFacade;
use Respect\Validation\Validator;
use App\Facades\UsersFacade;

/**
 * Class AuthController
 * @package App\Controllers
 */
class AuthController extends Controller
{

    private const NAMED_ROUTE_AUTH = 'auth';
    private const NAMED_ROUTE_SIGNUP = 'signup';
    private const PAGE_AUTH = 'pages/backoffice/auth.php';
    private const PAGE_SIGNUP = 'pages/backoffice/signup.php';
    private const PAGE_LOSTPASSWORD = 'pages/backoffice/authLostPassword.php';
    private const PAGE_RESETPASSWORD = 'pages/backoffice/authResetPassword.php';

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showAuth(Request $request, Response $response): Response
    {
        if (AuthFacade::isLogged()) {
            $response = $this->redirect($response, self::NAMED_ROUTE_BACKOFFICE);
        } else {
            $response = $this->render($response, self::PAGE_AUTH);
        }

        return $response;
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showSignup(Request $request, Response $response): Response
    {
        if (AuthFacade::isLogged()) {
            $response = $this->redirect($response, self::NAMED_ROUTE_BACKOFFICE);
        } else {
            $subscribersCnt = UsersFacade::subscribersCnt($this->container);
            $response = $this->render($response, self::PAGE_SIGNUP, ['enable' => $subscribersCnt < MAX_SUBSCRIBERS_CNT]);
        }

        return $response;
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showLostPassword(Request $request, Response $response): Response
    {
        if (AuthFacade::isLogged()) {
            $response = $this->redirect($response, self::NAMED_ROUTE_BACKOFFICE);
        } else {
            $response = $this->render($response, self::PAGE_LOSTPASSWORD);
        }

        return $response;
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showResetPassword(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();

        if(!empty($params['token'])) {
            $profil = UsersFacade::getProfileByToken($this->container, $params['token']);
            if(!empty($profil['userid'])) {
                $datas = [
                    'user' => $profil,
                ];
                return $this->render($response, self::PAGE_RESETPASSWORD, $datas);
            }
        }

        return $this->render($response, self::PAGE_AUTH);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function sendNewPassword(Request $request, Response $response): Response
    {
        $post = $request->getParsedBody();
        $result = AuthFacade::sendNewPasswordEmail($this->container, $post['username']);

        if ($result) {
            $this->messageService->addMessage('success', _['MSG_SUCCESS_LOSTPASSWORDEMAIL']);
        } else {
            $this->messageService->addMessage('error', self::_['MSG_ERROR']);
        }

        return $response = $this->redirect($response, self::NAMED_ROUTE_AUTH);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function resetPassword(Request $request, Response $response): Response
    {
        $post = $request->getParsedBody();
        $result = AuthFacade::resetPassword($this->container, $post['username'], $post['password']);

        if ($result) {
            $this->messageService->addMessage('success', _['MSG_SUCCESS_RESETPASSWORD']);
        } else {
            $this->messageService->addMessage('error', _['MSG_ERROR']);
        }

        return $response = $this->redirect($response, self::NAMED_ROUTE_AUTH);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function confirmEmail(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();

        $result = AuthFacade::confirmEmail($this->container, $params['username'], $params['token']);

        if ($result) {
            $this->messageService->addMessage('success', _['MSG_SUCCESS_CONFIRMEMAIL']);
        } else {
            $this->messageService->addMessage('error', _['MSG_ERROR_CONFIRMEMAIL']);
        }

        return $response = $this->redirect($response, self::NAMED_ROUTE_AUTH);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function login(Request $request, Response $response): Response
    {
        $namedRoute = self::NAMED_ROUTE_AUTH;
        $post = $request->getParsedBody();

        $validUsername = Validator::notEmpty()->alnum()
            ->noWhitespace()
            ->validate($post['username']);
        $validPassword = Validator::notEmpty()->validate($post['password']);

        if ($validUsername and $validPassword) {
            $result = AuthFacade::authentificateUser($this->container, $post['username'], $post['password']);
            if (! $result) {
                $this->messageService->addMessage('error', _['MSG_ERROR_LOGIN']);
            } else {
                $namedRoute = self::NAMED_ROUTE_BACKOFFICE;
            }
        } else {
            $this->messageService->addMessage('error', _['MSG_ERROR_LOGIN']);
        }

        return $this->redirect($response, $namedRoute);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function logout(Request $request, Response $response): Response
    {
        AuthFacade::logout();
        $this->messageService->addMessage('success', _['MSG_LOGOUT']);
        return $this->redirect($response, self::NAMED_ROUTE_HOME);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function signup(Request $request, Response $response): Response
    {
        $errors = [];
        $namedRoute = self::NAMED_ROUTE_SIGNUP;
        $post = $request->getParsedBody();

        Validator::notEmpty()->noWhitespace()
            ->alnum()
            ->length(1, 99)
            ->validate($post['username']) || $errors['username'] = _['MSG_VALID_USERNAME'];
        Validator::notEmpty()->length(1, 99)->validate($post['password']) || $errors['password'] = _['MSG_VALID_PASSWORD'];
        Validator::notEmpty()->equals($post['password'])->validate($post['password2']) || $errors['password2'] = _['MSG_VALID_PASSWORDCONFIRM'];
        Validator::notEmpty()->email()->validate($post['email']) || $errors['email'] = _['MSG_VALID_EMAIL'];


        if (empty($errors)) {
            # Check uniques values for username and email
            $duplicates = UsersFacade::searchUsersByNameOrEmail($this->container, $post['username'], $post['email']);
            if(!empty($duplicates)) {
                $this->messageService->addMessage('error', 'DUPLICATE_VALUES');
                foreach($duplicates as $f) {
                    $this->messageService->addMessage($f, strtoupper($f) .'_ALREADY_EXISTS');
                }
            } elseif (UsersFacade::addUser($this->container, $post) and AuthFacade::sendConfirmationEmail($this->container, $post['username'])) {
                $this->messageService->addMessage('success', _['MSG_SUCCESS_SIGNUP']);
                $namedRoute = self::NAMED_ROUTE_AUTH;
            } else {
                $this->messageService->addMessage('error', _['MSG_ERROR_TECHNICAL']);
            }
        } else {
            $this->messageService->addMessage('error', _['MSG_ERROR_SIGNUP']);
            foreach ($errors as $key => $message) {
                $this->messageService->addMessage($key, $message);
            }
        }

        return $this->redirect($response, $namedRoute);
    }
}