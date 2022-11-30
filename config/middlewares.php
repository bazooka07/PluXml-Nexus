<?php
/**
 * SLIM 4 middleware creation
 */
use App\Middlewares\FormOldValuesMiddleware;
use App\Middlewares\CsrfTokenMiddleware;
use App\Middlewares\RouterViewMiddleware;
use App\Middlewares\IsLoggedMiddleware;
use App\Handlers\HttpErrorHandler;

/**
 * Middlewares
 * The last to be added is the first to be executed
 *
 * FormOldValuesMiddleware store in $_SESSION the form values
 * CsrfTokenMiddleware SLIM 4 CSRF tokens generation
 * csrf SLIM 4 CSRF engine added from PHP-DI container
 */
$app->add(new FormOldValuesMiddleware($container));
$app->add(new IsLoggedMiddleware($container));
$app->add(new RouterViewMiddleware($container));
$app->add(new CsrfTokenMiddleware($container));
$app->add('csrf');

// SLIM4 ErrorMiddleware
$errorMiddleware = $app->addErrorMiddleware(DEBUG, false, false);

if(! DEBUG) {
    $callableResolver = $app->getCallableResolver();
    $responseFactory = $app->getResponseFactory();
    $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
}
