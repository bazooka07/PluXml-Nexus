<?php
/**
 * ProfilesController
 */
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\UsersFilter;
use App\Facades\UsersFacade;

class ProfilesController extends Controller
{

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response)
    {
        return $this->render($response, 
            'pages/profiles.php', 
            UsersFacade::getAllProfiles($this->container, UsersFilter::Contributors)
        );
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param Array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showProfile(Request $request, Response $response, $args)
    {
        return $this->render($response, 
            'pages/profile.php', 
            UsersFacade::getProfile($this->container, $args['username'], true)
        );
    }
}