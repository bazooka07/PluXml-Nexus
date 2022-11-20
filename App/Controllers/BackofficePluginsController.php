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
class BackofficePluginsController extends BackofficeController
{

    protected const RESSOURCE = 'plugin';
    protected const NAMED_ROUTE_BO = 'bo' . self::RESSOURCE . 's';

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
    public function showAllItems(Request $request, Response $response): Response
    {
        return $this->render($response,
            'pages/backoffice/' . self::RESSOURCE .'s.php',
            [
                'h3' => _[strtoupper(self::RESSOURCE . 's')],
                'items' => PluginsFacade::getAllItems($this->container, $this->currentUserId),
                'ressource' => self::RESSOURCE,
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
    public function showItem(Request $request, Response $response, array $args): Response
    {
        return $this->render($response,
            'pages/backoffice/edit' . ucfirst(self::RESSOURCE) . '.php',
            [
                'h3' => 'Edit ' . self::RESSOURCE . ' ' . $args['name'],
                'item' => PluginsFacade::getItem($this->container, $args['name'], $args['author']),
                'ressource' => self::RESSOURCE,
                'categories' => CategoriesFacade::getCategories($this->container, true),
            ]
        );
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showAddItem(Request $request, Response $response): Response
    {
        return $this->render($response,
            'pages/backoffice/add' . ucfirst(self::RESSOURCE) . '.php',
            [
                'h3' => _['NEW_' . strtoupper(self::RESSOURCE)],
        'ressource' => self::RESSOURCE,
                'categories' => CategoriesFacade::getCategories($this->container, true),
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
    public function editItem(Request $request, Response $response, array $args): Response
    {
        $namedRoute = 'boedit' . self::RESSOURCE;

        $errors = self::ressourceValidator($request);

        if (empty($errors)) {
            if (PluginsFacade::editItem($this->container, $this->post)) {
                $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_EDITRESSOURCE, $this->ressourceType));
                $namedRoute = self::NAMED_ROUTE_BO;
            } else {
                # Delete the ressource !!!
                $this->messageService->addMessage('error', sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType));
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
    public function saveItem(Request $request, Response $response): Response
    {
        $namedRoute = 'boadd' . $this->ressource;

        $errors = self::ressourceValidator($request, true);
        // Validator error and the item does not exist
        if (empty($errors) && empty(PluginsFacade::getItem($this->container, $this->post['name'], $this->post['author']))) {
            if (PluginsFacade::saveItem($this->container, $this->post)) {
                $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_EDITRESSOURCE, $this->ressourceType));
                $namedRoute = self::NAMED_ROUTE_BO;
            } else {
                # Delete the item in the database ?
                $errors['error'] = sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
            }
        } else {
            $errors['error'] = sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
        }

        if (!empty($errors)) {
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
    public function deleteItem(Request $request, Response $response, array $args): Response
    {
        if (PluginsFacade::deleteItem($this->container, $args['author'], $args['name'])) {
            $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_DELETERESSOURCE, $this->ressourceType));
        } else {
            $this->messageService->addMessage('error', sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType));
        }

        return $this->redirect($response, self::NAMED_ROUTE_BO);
    }

}
