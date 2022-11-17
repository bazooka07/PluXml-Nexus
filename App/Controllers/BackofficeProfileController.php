<?php

namespace App\Controllers;

use App\Facades\UsersFacade;
use App\Controllers\BackofficeController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator;

/**
 * Class BackofficeProfileController
 * @package App\Controllers
 */
class BackofficeProfileController extends BackOfficeController
{

    private const MSG_SUCCESS_EDITPROFILE = 'Profile updated with success.';

    private const MSG_ERROR_EDITPROFILE = 'Profile can not be updated, see errors below.';

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showEditProfile(Request $request, Response $response)
    {
        $datas = UsersFacade::getProfile($this->container, $this->currentUser);
        $datas['h3'] = _['MY_PROFILE'];

        return $this->render($response, 'pages/backoffice/editProfile.php', $datas);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function edit(Request $request, Response $response, $args)
    {
        $namedRoute = self::NAMED_ROUTE_BACKOFFICE;
        $post = $request->getParsedBody();

        Validator::notEmpty()->email()->validate($post['email']) || $errors['email'] = self::MSG_VALID_EMAIL;
        Validator::url()->length(1, 99)->validate($post['website']) || $errors['website'] = self::MSG_VALID_URL;

        if (empty($errors)) {
            if (UsersFacade::editUser($this->container, $post)) {
                $this->messageService->addMessage('success', self::MSG_SUCCESS_EDITPROFILE);
                $namedRoute = self::NAMED_ROUTE_BACKOFFICE;
            } else {
                $this->messageService->addMessage('error', self::MSG_ERROR_TECHNICAL);
            }
        } else {
            $this->messageService->addMessage('error', self::MSG_ERROR_EDITPROFILE);
            foreach ($errors as $key => $message) {
                $this->messageService->addMessage($key, $message);
            }
        }

        return $this->redirect($response, $namedRoute, $args);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function changePassword(Request $request, Response $response, $args)
    {
        $namedRoute = self::NAMED_ROUTE_BACKOFFICE;

        return $this->redirect($response, $namedRoute, $args);
    }
}
