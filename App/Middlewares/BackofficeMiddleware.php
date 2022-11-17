<?php
/**
 * IsLoggedMiddleware
 */
namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Container\ContainerInterface;
use App\Facades\AuthFacade;

class BackofficeMiddleware extends Middleware
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        if (! AuthFacade::isLogged()) {
            $this->flashService->addMessage('error', _['AUTHENTIFCIATION_REQUIRED']);
            return $response->withHeader('Location', $this->routerService->urlFor('auth'))->withStatus(302);
        }
        return $response;
    }
}