<?php
/**
 * Nexus a PluXml ressources sharing
 * @author Pedro CADETE <pedro@hyperion-web.fr>
 * @link https://ressources.pluxml.org
 */
use DI\Container;
use Slim\Factory\AppFactory;

// Composer autoloader
require_once '../vendor/autoload.php';

// Start the PHP session
session_start();

// NEXUS application global settings
require_once '../config/settings.php';

require_once '../App/Translations/fr.php';

function reverseDate($input, $format='$3/$2/$1 $4h$5') {
    return preg_replace('#^(\d{4})-(\d{2})-(\d{2})\s+(\d{2}):(\d{2}).*#', $format, $input);
}

// SLIM4 application initialisation with the PHP-DI container
$container = new Container;
AppFactory::setContainer($container);
$app = AppFactory::create();

// SLIM4 container
require_once '../config/containers.php';

// SLIM4 middleware
require_once '../config/middlewares.php';

// SLIM4 routes creation
require_once '../config/routes.php';

// SLIM4 application launching
const PUBLIC_DIR = __DIR__;

$app->run();
