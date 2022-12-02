<?php

namespace App\Controllers;

use App\Facades\AuthFacade;
use App\Facades\UsersFacade;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class BackofficeUsersController
 * @package App\Controllers
 */
class BackofficeUsersController extends Controller
{
    const VIEW_BO_USERS = 'pages/backoffice/users.php';

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showUsers(Request $request, Response $response): Response
    {
        $view = self::VIEW_BO_USERS;

        if (AuthFacade::isAdmin($this->container, $this->currentUser)) {
            list($expired, $now) = UsersFacade::expiredUsersCnt($this->container);
            $datas = [
                'title' => 'Backoffice Ressources - PluXml.org',
                'h2' => 'Backoffice',
                'h3' => 'Users',
                'expired' => $expired,
                'now' => $now,
            ];
            $datas = array_merge($datas, UsersFacade::getAllProfilesWithAndWithoutPlugins($this->container));
        } else {
            $datas = [];
            $view = parent::VIEW_BO_USERS;
        }

        return $this->render($response, $view, $datas);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function removeUsers(Request $request, Response $response, array $args)
    {
        if (AuthFacade::isAdmin($this->container, $this->currentUser)) {
            UsersFacade::removeUser($this->container, $args['username']);
        }
    }

    public function removeExpiredUsers(Request $request, Response $response)
    {
        if (AuthFacade::isAdmin($this->container, $this->currentUser)) {
            if(UsersFacade::removeExpiredUsers($this->container) > 0) {
                $this->container->get('flash')->addMessage('success', 'Expired users are dropped !');
            }
        }

        return $this->redirect($response, 'bousers');
    }
}