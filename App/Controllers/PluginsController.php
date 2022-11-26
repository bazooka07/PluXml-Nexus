<?php
/**
 * PluginsController
 */
namespace App\Controllers;

use App\Facades\CategoriesFacade;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Facades\PluginsFacade;

class PluginsController extends Controller
{
    protected const RESSOURCE = 'plugin';  
    private const ACTIVE_TAB = 3;
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
                self::RESSOURCE . 's' => PluginsFacade::getAllItems($this->container),
                'categories' => CategoriesFacade::getCategories($this->container),
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
                'item' => PluginsFacade::getItem($this->container, $args['name'], $args['author']),
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
    public function showCategory(Request $request, Response $response, $args)
    {
        return $this->render($response,
            self::VIEW_ALL_ITEMS,
            [
                'activeTab' => self::ACTIVE_TAB,
                'categories' => CategoriesFacade::getCategories($this->container),
                'category' => $args['name'],
                'plugins' => CategoriesFacade::getPluginsForCategory($this->container, $args['name']),
            ]
        );
    }
}
