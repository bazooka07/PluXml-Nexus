<?php
namespace App\Controllers;

use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Facades\ThemesFacade;

/**
 * Class BackofficeThemesController
 * @package App\Controllers
 */
class BackofficeThemesController extends BackofficeController
{

    private const NAMED_ROUTE_BOTHEMES = 'bothemes';
    private const NAMED_ROUTE_SAVETHEME = 'boaddtheme';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->ressourceType = 'theme';
        $this->dirTarget = DIR_THEMES;
        $this->mediaName = 'preview';
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface Response
     */
    public function show(Request $request, Response $response): Response
    {
        return $this->render($response,
            'pages/backoffice/themes.php',
            [
                'h3' => _['THEMES'],
                'themes' => ThemesFacade::getAllItem($this->container, $this->currentUserId),
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
    public function showTheme(Request $request, Response $response, array $args): Response
    {
        return $this->render($response,
            'pages/backoffice/editTheme.php',
            [
                'h3' => 'Edit theme ' . $args['name'],
                'theme' => ThemesFacade::getItem($this->container, $args['name'], $args['author']),
            ]
        );
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showAddTheme(Request $request, Response $response): Response
    {
        return $this->render($response,
            'pages/backoffice/addTheme.php',
            [
                'h2' => 'Backoffice',
                'h3' => 'New theme',
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
        $errors = self::ressourceValidator($request);

        if (empty($errors)) {
            if (ThemesFacade::editTheme($this->container, $this->post)) {
                $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_EDITRESSOURCE, $this->ressourceType));
            } else {
                # Delete the ressource !!!
                $this->messageService->addMessage('error', sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType));
            }
        } else {
            foreach ($errors as $key => $message) {
                $this->messageService->addMessage($key, $message);
            }
        }

        return $this->redirect($response, self::NAMED_ROUTE_BOTHEMES, $args);
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
        $namedRoute = self::NAMED_ROUTE_SAVETHEME;

        $errors = self::ressourceValidator($request, true);

        // Validator error and theme does not exist
        if (empty($errors) && empty(ThemesFacade::getItem($this->container, $this->post['name']))) {
            if (ThemesFacade::saveTheme($this->container, $this->post)) {
                $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_EDITRESSOURCE, $this->ressourceType));
                $namedRoute = self::NAMED_ROUTE_BOTHEMES;
            } else {
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
    public function delete(Request $request, Response $response, array $args): Response
    {
        if (ThemesFacade::deleteTheme($this->container, $args['name'])) {
            $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_DELETERESSOURCE, $this->ressourceType));
        } else {
            $this->messageService->addMessage('error', sprintf(self::MSG_ERROR_TECHNICAL_RESSOURCES, $this->ressourceType));
        }

        return $this->redirect($response, self::NAMED_ROUTE_BOTHEMES);
    }

}
