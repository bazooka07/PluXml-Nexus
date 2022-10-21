<?php

namespace App\Controllers;

use App\Facades\CategoriesFacade;
use App\Controllers\BackofficeController;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Facades\PluginsFacade;
use Respect\Validation\Validator;

/**
 * Class BackofficePluginsController
 * @package App\Controllers
 */
class BackofficePluginsController extends BackOfficeController
{

    private const NAMED_ROUTE_BOPLUGINS = 'boplugins';

    private const NAMED_ROUTE_SAVEPLUGIN = 'boaddplugin';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->ressourceType = 'plugin';
        $this->dirTarget = PUBLIC_DIR . DIR_PLUGINS;
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
        $post = $request->getParsedBody();

        $errors = self::ressourceValidator($request, false, isset($post['file']));

        if (empty($errors)) {
            if (PluginsFacade::editPlugin($this->container, $post)) {
                $result = true;
                if (isset($post['file'])) {
                    $filename = $post['name'] . '.zip';
                    $dirTmp = PUBLIC_DIR . DIR_TMP;
                    $result = rename($dirTmp . DIRECTORY_SEPARATOR . $filename, $this->dirTarget . DIRECTORY_SEPARATOR . $filename);
                }
                if ($result) {
                    $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_EDITRESSOURCE, $this->ressourceType));
                } else {
                    $errors['error'] = sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
                }
            } else {
                $this->messageService->addMessage('error', self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
            }
        } else {
            $this->messageService->addMessage('error', self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
            foreach ($errors as $key => $message) {
                $this->messageService->addMessage($key, $message);
            }
        }

        return $this->redirect($response, self::NAMED_ROUTE_BOPLUGINS, $args);
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
        $post = $request->getParsedBody();
        $errors = self::ressourceValidator($request, true);

        // Validator error and plugin does not exist
        if (empty($errors) && empty(PluginsFacade::getPlugin($this->container, $post['name']))) {
            if (PluginsFacade::savePlugin($this->container, $post)) {
                $filename = $post['name'] . '.zip';
                $dirTmp = PUBLIC_DIR . DIR_TMP;
                if (!file_exists($this->dirTarget . DIRECTORY_SEPARATOR . $filename)) {
                    $result = rename($dirTmp . DIRECTORY_SEPARATOR . $filename, $dirTarget . DIRECTORY_SEPARATOR . $filename);
                    if ($result) {
                        $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_EDITRESSOURCE, $this->ressourceType));
                    } else {
                        $errors['error'] = sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
                    }
                } else {
                    $errors['error'] = sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
                }
            } else {
                $errors['error'] = sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
            }
        } else {
            $errors['error'] = sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType);
        }

        if (empty($errors)) {
            $namedRoute = self::NAMED_ROUTE_BOPLUGINS;
        } else {
            foreach ($errors as $key => $message) {
                $this->messageService->addMessage($key, $message);
            }
            $namedRoute = self::NAMED_ROUTE_SAVEPLUGIN;
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
