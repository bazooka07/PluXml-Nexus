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

    private const MSG_ERROR_LOGIN = 'Wrong username or password';

    private const MSG_ERROR_SIGNUP = 'Signup error, please see below';

    private const MSG_ERROR_CONFIRMEMAIL = 'Email confirmation failed';

    private const MSG_SUCCESS_SIGNUP = 'Signup successful, please confirm your email address to be able to login';

    private const MSG_SUCCESS_CONFIRMEMAIL = 'Email address confirmation success';

    private const MSG_SUCCESS_LOSTPASSWORDEMAIL = 'An e-mail has been sent to you, allowing you to reset your password';

    private const MSG_SUCCESS_RESETPASSWORD = 'Your password has been updated';

    private const MSG_LOGOUT = 'Log out successful';

    private const MSG_VALID_USERNAME = 'Must be alphanumeric with no whitespace';

    private const MSG_VALID_PASSWORD = 'Lengh must be inferior to 100 characters';

    private const MSG_VALID_PASSWORDCONFIRM = 'Password does not match';

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

        $result = AuthFacade::confirmLostPasswordToken($this->container, $params['token']);

        if ($result) {
            $datas['user'] = UsersFacade::getProfile($this->container, $params['token']);
            $response = $this->render($response, self::PAGE_RESETPASSWORD, $datas);
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
    public function sendNewPassword(Request $request, Response $response): Response
    {
        $post = $request->getParsedBody();
        $result = AuthFacade::sendNewPasswordEmail($this->container, $post['username']);

        if ($result) {
            $this->messageService->addMessage('success', self::MSG_SUCCESS_LOSTPASSWORDEMAIL);
        } else {
            $this->messageService->addMessage('error', self::MSG_ERROR);
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
            $this->messageService->addMessage('success', self::MSG_SUCCESS_RESETPASSWORD);
        } else {
            $this->messageService->addMessage('error', self::MSG_ERROR);
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
            $this->messageService->addMessage('success', self::MSG_SUCCESS_CONFIRMEMAIL);
        } else {
            $this->messageService->addMessage('error', self::MSG_ERROR_CONFIRMEMAIL);
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
                $this->messageService->addMessage('error', self::MSG_ERROR_LOGIN);
            } else {
                $namedRoute = self::NAMED_ROUTE_BACKOFFICE;
            }
        } else {
            $this->messageService->addMessage('error', self::MSG_ERROR_LOGIN);
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
        $this->messageService->addMessage('success', self::MSG_LOGOUT);
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
            ->validate($post['username']) || $errors['username'] = self::MSG_VALID_USERNAME;
        Validator::notEmpty()->length(1, 99)->validate($post['password']) || $errors['password'] = self::MSG_VALID_PASSWORD;
        Validator::notEmpty()->equals($post['password'])->validate($post['password2']) || $errors['password2'] = self::MSG_VALID_PASSWORDCONFIRM;
        Validator::notEmpty()->email()->validate($post['email']) || $errors['email'] = self::MSG_VALID_EMAIL;

        if (empty($errors)) {
            if (UsersFacade::addUser($this->container, $post) and AuthFacade::sendConfirmationEmail($this->container, $post['username'])) {
                $this->messageService->addMessage('success', self::MSG_SUCCESS_SIGNUP);
                $namedRoute = self::NAMED_ROUTE_AUTH;
            } else {
                $this->messageService->addMessage('error', self::MSG_ERROR_TECHNICAL);
            }
        } else {
            $this->messageService->addMessage('error', self::MSG_ERROR_SIGNUP);
            foreach ($errors as $key => $message) {
                $this->messageService->addMessage($key, $message);
            }
        }

        return $this->redirect($response, $namedRoute);
    }
}