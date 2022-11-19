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
    private const ACTIVE_TAB = 3;
    private const VIEW_ALL = 'pages/plugins.php';
    private const VIEW_PLUGIN = 'pages/plugin.php';

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response)
    {
        return $this->render($response,
            self::VIEW_ALL,
            [
                'activeTab' => self::ACTIVE_TAB,
                'categories' => CategoriesFacade::getCategories($this->container),
                'plugins' => PluginsFacade::getAllItem($this->container),
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
            self::VIEW_ALL,
            [
                'activeTab' => self::ACTIVE_TAB,
                'categories' => CategoriesFacade::getCategories($this->container),
                'category' => $args['name'],
                'plugins' => CategoriesFacade::getPluginsForCategory($this->container, $args['name']),
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
    public function showPlugin(Request $request, Response $response, $args)
    {
        return $this->render($response,
            self::VIEW_PLUGIN,
            [
                'activeTab' => self::ACTIVE_TAB,
                'plugin' => PluginsFacade::getItem($this->container, $args['name'], $args['author']),
            ]
        );
    }
}
