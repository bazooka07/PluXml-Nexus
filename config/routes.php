<?php
/**
 * SLIM4 routes creation
 */
use App\Controllers\HomeController;
use App\Controllers\PluginsController;
use App\Controllers\ProfilesController;
use App\Controllers\ThemesController;
use App\Controllers\AuthController;
use App\Controllers\BackofficeController;
use App\Middlewares\BackofficeMiddleware;
use Slim\Interfaces\RouteCollectorProxyInterface;
use App\Controllers\BackofficePluginsController;
use App\Controllers\BackofficeThemesController;
use App\Controllers\BackofficeProfileController;

$app->get('/', HomeController::class . ':show')->setName('homepage');

$app->get('/plugins', PluginsController::class . ':show')->setName('plugins');
$app->get('/plugins/{name}', PluginsController::class . ':showPlugin')->setName('plugin');

$app->get('/themes', ThemesController::class . ':show')->setName('themes');
$app->get('/themes/{name}', ThemesController::class . ':showTheme')->setName('theme');

$app->get('/profiles', ProfilesController::class . ':show')->setName('profiles');
$app->get('/profiles/{username}', ProfilesController::class . ':showProfile')->setName('profile');

$app->get('/auth', AuthController::class . ':showAuth')->setName('auth');
$app->get('/signup', AuthController::class . ':showSignup')->setName('signup');
$app->get('/auth/logout', AuthController::class . ':logout')->setName('logoutAction');
$app->get('/auth/emailconfirmation', AuthController::class . ':confirmEmail')->setName('confirmEmail');
$app->post('/auth/login', AuthController::class . ':login')->setName('loginAction');
$app->post('/signup', AuthController::class . ':signup')->setName('signupAction');

$app->group('/backoffice', function (RouteCollectorProxyInterface $group) {

    $group->get('', BackofficeController::class . ':show')->setName('backoffice');
    $group->get('/plugins', BackofficePluginsController::class . ':show')->setName('boplugins');
    $group->get('/plugins/{name}', BackofficePluginsController::class . ':showPlugin')->setName('boeditplugin');
    $group->get('/plugin/add', BackofficePluginsController::class . ':showAddPlugin')->setName('boaddplugin');
    $group->get('/themes', BackofficeThemesController::class . ':show')->setName('bothemes');
    $group->get('/themes/{name}', BackofficeThemesController::class . ':showTheme')->setName('boedittheme');
    $group->get('/theme/add', BackofficeThemesController::class . ':showAddTheme')->setName('boaddtheme');
    $group->get('/profile', BackofficeProfileController::class . ':showEditProfile')->setName('boeditprofile');

    $group->post('/plugin/save', BackofficePluginsController::class . ':save')->setName('pluginSaveAction');
    $group->post('/plugin/edit/{name}', BackofficePluginsController::class . ':edit')->setName('pluginEditAction');
    $group->post('/theme/save', BackofficeThemesController::class . ':save')->setName('themeAction');
    $group->post('/profile/save', BackofficeProfileController::class . ':save')->setName('profileAction');

})->add(new BackofficeMiddleware($container));