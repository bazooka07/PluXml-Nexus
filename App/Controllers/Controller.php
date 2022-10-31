<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{

    protected ContainerInterface $container;

    protected $routerService;

    protected $viewService;

    protected $messageService;

    protected $mailService;

    protected $currentUser;

    protected const NAMED_ROUTE_HOME = 'homepage';

    protected const NAMED_ROUTE_BACKOFFICE = 'backoffice';

    protected const MSG_VALID_EMAIL = 'Invalid email address';

    protected const MSG_VALID_URL = 'Invalid url';

    protected const MSG_ERROR = 'An error occured';

    protected const MSG_ERROR_TECHNICAL = 'Technical error';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->routerService = $this->container->get('router');
        $this->viewService = $this->container->get('view');
        $this->messageService = $this->container->get('flash');
        $this->mailService = $this->container->get('mail');
        $this->currentUser = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $this->currentUserId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    }

    /**
     * HTTP redirect
     *
     * @param Response $response
     * @param String $namedRoute
     * @param array $args
     * @param int $status
     * @return Response
     */
    public function redirect(Response $response, $namedRoute, $args = [], $status = 302)
    {
        return $response->withHeader('Location', $this->routerService->urlFor($namedRoute, $args))
            ->withStatus($status);
    }

    /**
     * PHP view renderer
     *
     * @param Response $response
     * @param String $filename
     * @param array $datas
     * @return Response
     */
    public function render(Response $response, $filename, $datas = [])
    {
        $datas['flash'] = $this->messageService->getMessages();
        if (empty($datas['title'])) {
            $datas['title'] = 'Ressources - PluXml.org';
        }
        return $this->viewService->render($response, $filename, $datas);
    }
}
