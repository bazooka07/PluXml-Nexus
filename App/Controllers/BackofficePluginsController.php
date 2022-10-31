<?php

namespace App\Controllers;

use App\Facades\CategoriesFacade;
use App\Controllers\BackofficeController;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Facades\PluginsFacade;

/**
 * Class BackofficePluginsController
 * @package App\Controllers
 */
class BackofficePluginsController extends BackOfficeController
{

    private const NAMED_ROUTE_BOPLUGINS = 'boplugins';
    private const NAMED_ROUTE_SAVEPLUGIN = 'boaddplugin';
    private const NAMED_ROUTE_EDITPLUGIN = 'boeditplugin';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->ressourceType = 'plugin';
        $this->dirTarget = DIR_PLUGINS;
        $this->mediaName = 'icon';
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface Response
     */
    public function show(Request $request, Response $response) : Response
    {
        return $this->render($response,
            'pages/backoffice/plugins.php', # view
            [
                'h3' => 'Plugins',
                'plugins' => PluginsFacade::getAllPlugins($this->container, $this->currentUser),
            ]
        );
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function showPlugin(Request $request, Response $response, array $args): Response
    {

        return $this->render($response,
            'pages/backoffice/editPlugin.php',
            [
                'h3' => 'Edit plugin ' . $args['name'],
                'plugin' => PluginsFacade::getPlugin($this->container, $args['name']),
                'categories' => CategoriesFacade::getCategories($this->container),
            ]
        );
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showAddPlugin(Request $request, Response $response): Response
    {
        return $this->render($response,
            'pages/backoffice/addPlugin.php',
            [
                'h3' => 'New plugin',
                'categories' => CategoriesFacade::getCategories($this->container),
            ]
        );
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws Exception
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        $namedRoute = self::NAMED_ROUTE_EDITPLUGIN;
 
        $errors = self::ressourceValidator($request);

        if (empty($errors)) {
            if (PluginsFacade::editPlugin($this->container, $this->post)) {
                $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_EDITRESSOURCE, $this->ressourceType));
                $namedRoute = self::NAMED_ROUTE_BOPLUGINS;
            } else {
                $this->messageService->addMessage('error', self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
            }
        } else {
            foreach ($errors as $key => $message) {
                $this->messageService->addMessage($key, $message);
            }
        }

        return $this->redirect($response, $namedRoute, $args);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws Exception
     */
    public function save(Request $request, Response $response): Response
    {
        $namedRoute = self::NAMED_ROUTE_SAVEPLUGIN;

        $post = $request->getParsedBody();
        $errors = self::ressourceValidator($request, true);

        // Validator error and plugin does not exist
        if (empty($errors) && empty(PluginsFacade::getPlugin($this->container, $post['name']))) {
            if (PluginsFacade::savePlugin($this->container, $post)) {
                $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_EDITRESSOURCE, $this->ressourceType));
                $namedRoute = self::NAMED_ROUTE_BOPLUGINS;
            } else {
                # Delete the plugin in the database !
            }
        } else {
            $errors['error'] = sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
        }

        if (empty($errors)) {
        } else {
            foreach ($errors as $key => $message) {
                $this->messageService->addMessage($key, $message);
            }
        }

        return $this->redirect($response, $namedRoute);
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        if (PluginsFacade::deletePlugin($this->container, $args['name'])) {
            $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_DELETERESSOURCE, $this->ressourceType));
        } else {
            $this->messageService->addMessage('error', sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType));
        }

        return $this->redirect($response, self::NAMED_ROUTE_BOPLUGINS);
    }

}
