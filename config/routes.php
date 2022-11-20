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
use App\Controllers\BackofficeUsersController;

$app->get('/', HomeController::class . ':show')->setName('homepage');

$app->get('/plugins/categories/{name}', PluginsController::class . ':showCategory')->setName('category');
$app->get('/plugins', PluginsController::class . ':showAllItems')->setName('plugins');
$app->get('/plugins/{author}/{name}', PluginsController::class . ':showItem')->setName('plugin');

$app->get('/themes', ThemesController::class . ':showAllItems')->setName('themes');
$app->get('/themes/{author}/{name}', ThemesController::class . ':showItem')->setName('theme');

$app->get('/profiles', ProfilesController::class . ':show')->setName('profiles');
$app->get('/profiles/{username}', ProfilesController::class . ':showProfile')->setName('profile');

$app->get('/auth', AuthController::class . ':showAuth')->setName('auth');
$app->get('/signup', AuthController::class . ':showSignup')->setName('signup');
$app->get('/auth/lostpassword', AuthController::class . ':showLostPassword')->setName('lostPassword');
$app->get('/auth/resetpassword', AuthController::class . ':showResetPassword')->setName('resetPassword');
$app->get('/auth/emailconfirmation', AuthController::class . ':confirmEmail')->setName('confirmEmail');
$app->get('/auth/logout', AuthController::class . ':logout')->setName('logoutAction');
$app->post('/auth/login', AuthController::class . ':login')->setName('loginAction');
$app->post('/auth/lostpassword', AuthController::class . ':sendNewPassword')->setName('lostPasswordAction');
$app->post('/auth/resetpassword', AuthController::class . ':resetPassword')->setName('resetPassword');
$app->post('/signup', AuthController::class . ':signup')->setName('signupAction');

$app->group('/backoffice', function (RouteCollectorProxyInterface $group) {

    $group->get('', BackofficeController::class . ':show')->setName('backoffice');

    $group->get('/plugins', BackofficePluginsController::class . ':showAllItems')->setName('boplugins');
    $group->get('/plugins/{author}/{name}', BackofficePluginsController::class . ':showItem')->setName('boeditplugin');
    $group->get('/plugin/add', BackofficePluginsController::class . ':showAddItem')->setName('boaddplugin');

    $group->get('/themes', BackofficeThemesController::class . ':showAllItems')->setName('bothemes');
    $group->get('/themes/{author}/{name}', BackofficeThemesController::class . ':showItem')->setName('boedittheme');
    $group->get('/theme/add', BackofficeThemesController::class . ':showAddItem')->setName('boaddtheme');

    $group->get('/profile', BackofficeProfileController::class . ':showEditProfile')->setName('boeditprofile');
    $group->get('/users', BackofficeUsersController::class . ':showUsers')->setName('bousers');
    $group->get('/users/expire', BackofficeUsersController::class . ':removeExpire')->setName('bormusers');
    $group->get('/users/remove/{userid}', BackofficeUsersController::class . ':removeUserId')->setName('bormuser');

    $group->post('/plugin/save', BackofficePluginsController::class . ':saveItem')->setName('pluginSaveAction');
    $group->post('/plugin/edit/{author}/{name}', BackofficePluginsController::class . ':editItem')->setName('pluginEditAction');
    $group->post('/plugin/delete/{author}/{name}', BackofficePluginsController::class . ':deleteItem')->setName('pluginDeleteAction');

    $group->post('/theme/save', BackofficeThemesController::class . ':saveItem')->setName('themeSaveAction');
    $group->post('/theme/edit/{author}/{name}', BackofficeThemesController::class . ':editItem')->setName('themeEditAction');
    $group->post('/theme/delete/{author}/{name}', BackofficeThemesController::class . ':deleteItem')->setName('themeDeleteAction');

    $group->post('/profile/edit', BackofficeProfileController::class . ':edit')->setName('profileSaveAction');
    $group->post('/profile/changePasword', BackofficeProfileController::class . ':save')->setName('profilePasswordAction');

})->add(new BackofficeMiddleware($container));
