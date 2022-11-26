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
    protected const RESSOURCE = 'theme';  
    private const ACTIVE_TAB = 2;
    private const VIEW_ALL_ITEMS = 'pages/' . self::RESSOURCE . 's.php';
    private const VIEW_ITEM = 'pages/' . self::RESSOURCE . '.php';

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAllItems(Request $request, Response $response)
    {
        return $this->render($response,
            self::VIEW_ALL_ITEMS,
            [
                'activeTab' => self::ACTIVE_TAB,
                self::RESSOURCE . 's' => ThemesFacade::getAllItems($this->container),
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
    public function showItem(Request $request, Response $response, $args)
    {
        return $this->render($response,
            self::VIEW_ITEM,
            [
                'activeTab' => self::ACTIVE_TAB,
                'item' => ThemesFacade::getItem($this->container, $args['name'], $args['author']),
            ]
        );
    }
}
