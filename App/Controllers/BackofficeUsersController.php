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
    private const BO_USERS_NAMED_ROUTE = 'bousers';
    protected const VIEW_BO_USERS = 'pages/backoffice/users.php';

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showUsers(Request $request, Response $response, $datas=[]): Response
    {
        $datas['h3'] = _['USERS'];
        if (AuthFacade::isAdmin($this->container, $this->currentUser)) {
            $datas = array_merge($datas, UsersFacade::getAllProfilesWithItemsCount($this->container));
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
    public function removeExpire(Request $request, Response $response): Response
    {
        if (AuthFacade::isAdmin($this->container, $this->currentUser)) {
            $cnt = UsersFacade::removeExpire($this->container);
            if($cnt !== false and $cnt > 0) {
                $this->messageService->addMessage('success', sprintf(_['DROPPED_USERS'], $cnt));
            } else {
                $this->messageService->addMessage('error', _['FAILED']);
            }
        } else {
            $this->messageService->addMessage('error', _['FAILED']);
        }

        return $this->redirect($response, self::BO_USERS_NAMED_ROUTE);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return void
     */
    public function removeUserId(Request $request, Response $response, array $args)
    {
        if (
            AuthFacade::isAdmin($this->container, $this->currentUser) and
            UsersFacade::removeUser($this->container, $args['id'])
        ) {
            $this->messageService->addMessage('success', sprintf(_['DROPPED_ONE_USER'], $args['username']));
        } else {
            $this->messageService->addMessage('error', _['FAILED']);
        }

        return $this->redirect($response, self::BO_USERS_NAMED_ROUTE);
    }

}
