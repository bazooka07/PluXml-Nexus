<?php

namespace App\Controllers;

use App\Facades\AuthFacade;
use App\Facades\UsersFacade;
use App\Models\UsersFilter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class BackofficeUsersController
 * @package App\Controllers
 */
class BackofficeUsersController extends BackofficeController
{

    protected const VIEW_BO_USERS = 'pages/backoffice/users.php';

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showUsers(Request $request, Response $response): Response
    {
        if (AuthFacade::isAdmin($this->container, $this->currentUser)) {
            $datas = UsersFacade::getAllProfilesWithItemsCount($this->container);
            $datas['h3'] = _['USERS'];
        } else {
            $datas = [];
        }

        return $this->render($response, self::VIEW_BO_USERS, $datas);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function removeExpire(Request $request, Response $response, array $args)
    {
        if (AuthFacade::isAdmin($this->container, $this->currentUser)) {
            UsersFacade::removeExpire($this->container);
        }
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function removeUserId(Request $request, Response $response, array $args)
    {
        if (AuthFacade::isAdmin($this->container, $this->currentUser)) {
            UsersFacade::removeUser($this->container, $args['userid']);
        }
    }

}
