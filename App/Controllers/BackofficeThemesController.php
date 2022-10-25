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
        $this->dirTarget = PUBLIC_DIR . DIR_THEMES;
    }

   /**
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response): Response
    {
        return $this->render($response,
            'pages/backoffice/themes.php',
            [
                'h3' => 'Themes',
                'themes' => ThemesFacade::getAllThemes($this->container, $this->currentUser),
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
                'theme' => ThemesFacade::getTheme($this->container, $args['name']),
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
        $post = $request->getParsedBody();

        $errors = self::ressourceValidator($request, false, isset($post['file']));

        if (empty($errors)) {
            if (ThemesFacade::editTheme($this->container, $post)) {
                $result = true;
                if (isset($post['file'])) {
                    $filename = $post['name'] . '.zip';
                    $target = $this->dirTarget . DIRECTORY_SEPARATOR . $filename;
                    $dirTmp = PUBLIC_DIR . DIR_TMP;
                    $result = rename($dirTmp . DIRECTORY_SEPARATOR . $filename, $target);
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
        $namedRoute = self::NAMED_ROUTE_BOTHEMES;
        $post = $request->getParsedBody();
        $errors = self::ressourceValidator($request, true);

        // Validator error and theme does not exist
        if (empty($errors) && empty(ThemesFacade::getTheme($this->container, $post['name']))) {
            if (ThemesFacade::saveTheme($this->container, $post)) {
                $filename = $post['name'] . '.zip';
                $target = $this->dirTarget . DIRECTORY_SEPARATOR . $filename;
                if (!file_exists($target)) {
                    $dirTmp = PUBLIC_DIR . DIR_TMP;
                    if (rename($dirTmp . DIRECTORY_SEPARATOR . $filename, $target))
                    {
                        $this->messageService->addMessage('success', sprintf(self::MSG_SUCCESS_EDITRESSOURCE, $this->ressourceType));
                    } else {
                        # Delete the theme in the database !
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

        if (!empty($errors)) {
            foreach ($errors as $key => $message) {
                $this->messageService->addMessage($key, $message);
            }
            $namedRoute = self::NAMED_ROUTE_SAVETHEME;
        }

        return $this->redirect($response, $namedRoute);
    }

}
