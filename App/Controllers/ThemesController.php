<?php
/**
 * ThemesController
 */
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Facades\ThemesFacade;

class ThemesController extends Controller
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
            'pages/themes.php',
            [
                'activeTab' => 2,
                'themes' => ThemesFacade::getAllThemes($this->container),
            ]
        );
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @param Array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showTheme(Request $request, Response $response, $args)
    {
        return $this->render($response,
            'pages/theme.php',
            ThemesFacade::getTheme($this->container, $args['name'])
        );
    }
}