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
$app->get('/plugins', PluginsController::class . ':show')->setName('plugins');
$app->get('/plugins/{name}', PluginsController::class . ':showPlugin')->setName('plugin');

$app->get('/themes', ThemesController::class . ':show')->setName('themes');
$app->get('/themes/{name}', ThemesController::class . ':showTheme')->setName('theme');

$app->get('/profiles', ProfilesController::class . ':show')->setName('profiles');
$app->get('/profiles/{username}', ProfilesController::class . ':showProfile')->setName('profile');

$app->get('/auth', AuthController::class . ':showAuth')->setName('auth');
$app->get('/signup', AuthController::class . ':showSignup')->setName('signup');
$app->get('/auth/lostpassword', AuthController::class . ':showLostPassword')->setName('lostPassword');
$app->get('/auth/resetpassword', AuthController::class . ':showResetPassword');
$app->get('/auth/emailconfirmation', AuthController::class . ':confirmEmail')->setName('confirmEmail');
$app->get('/auth/logout', AuthController::class . ':logout')->setName('logoutAction');
$app->post('/auth/login', AuthController::class . ':login')->setName('loginAction');
$app->post('/auth/lostpassword', AuthController::class . ':sendNewPassword')->setName('lostPasswordAction');
$app->post('/auth/resetpassword', AuthController::class . ':resetPassword')->setName('resetPassword');
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
    $group->get('/users', BackofficeUsersController::class . ':showUsers')->setName('bousers');
    $group->get('/users/remove/{username}', BackofficeUsersController::class . ':removeUsers')->setName('bormuser');
    $group->get('/users/expired', BackofficeUsersController::class . ':removeExpiredUsers')->setName('boexpiredusers');

    $group->post('/plugin/save', BackofficePluginsController::class . ':save')->setName('pluginSaveAction');
    $group->post('/plugin/edit/{name}', BackofficePluginsController::class . ':edit')->setName('pluginEditAction');
    $group->post('/plugin/delete/{name}', BackofficePluginsController::class . ':delete')->setName('pluginDeleteAction');
    $group->post('/theme/save', BackofficeThemesController::class . ':save')->setName('themeSaveAction');
    $group->post('/theme/edit/{name}', BackofficeThemesController::class . ':edit')->setName('themeEditAction');
    $group->post('/theme/delete/{name}', BackofficeThemesController::class . ':delete')->setName('themeDeleteAction');
    $group->post('/profile/edit', BackofficeProfileController::class . ':edit')->setName('profileSaveAction');
    $group->post('/profile/changePasword', BackofficeProfileController::class . ':save')->setName('profilePasswordAction');

})->add(new BackofficeMiddleware($container));