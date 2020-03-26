<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->configure('auth');
$app->configure('cors');
$app->configure('constans');
$app->configure('database');
$app->configure('filesystems');
$app->configure('mail');
$app->configure('repository');
$app->configure('queue');

$app->withFacades(true, [
    App\Library\Managers\Navigation\Facade\Navigation::class => 'Navigation',
    App\Library\Managers\Authority\Facade\Authority::class => 'Authority',
    Illuminate\Support\Facades\Mail::class => 'Mail'
    
]);

$app->withEloquent();

$app->bind(\Illuminate\Contracts\Routing\UrlGenerator::class, function ($app) {
    return new \Laravel\Lumen\Routing\UrlGenerator($app);
});

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    // App\Http\Middleware\CorsMiddleware::class
    \Fruitcake\Cors\HandleCors::class,
]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'client' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
    // 'cors' => App\Http\Middleware\CorsMiddleware::class
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/
/* Managers */
$app->register(App\Library\Managers\Navigation\Providers\NavigationServiceProvider::class);
$app->register(App\Library\Managers\Authority\Providers\AuthorityServiceProvider::class);

/* Modules */
$app->register(App\Modules\Auth\Providers\AuthServiceProvider::class);
$app->register(App\Modules\Test\Providers\TestServiceProvider::class);
$app->register(App\Modules\User\Providers\UserServiceProvider::class);
$app->register(App\Modules\Menu\Providers\MenuServiceProvider::class);
$app->register(App\Modules\Role\Providers\RoleServiceProvider::class);
$app->register(App\Modules\Setting\Providers\SettingServiceProvider::class);
$app->register(App\Modules\OutgoingMail\Providers\OutgoingMailServiceProvider::class);

$app->register(App\Modules\Master\Type\Providers\TypeServiceProvider::class);
$app->register(App\Modules\Master\Classification\Providers\ClassificationServiceProvider::class);
$app->register(App\Modules\Master\ClassDisposition\Providers\ClassDispositionServiceProvider::class);
$app->register(App\Modules\Master\TypeNote\Providers\TypeNoteServiceProvider::class);
$app->register(App\Modules\Master\Template\Providers\TemplateServiceProvider::class);

/* External */
$app->register(App\Modules\External\Employee\Providers\EmployeeServiceProvider::class);

/* Core */
$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(Illuminate\Mail\MailServiceProvider::class);
/* Passport */
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);

/* Repositories */
$app->register(Prettus\Repository\Providers\LumenRepositoryServiceProvider::class);

/* CORS */
$app->register(\Fruitcake\Cors\CorsServiceProvider::class);
/* TCPDF */
$app->register(Elibyy\TCPDF\ServiceProvider::class);
class_alias(Elibyy\TCPDF\Facades\TCPDF::class, 'PDF');
/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/
Dusterio\LumenPassport\LumenPassport::routes($app->router, ['prefix' => 'api/v1/oauth']);

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

app('translator')->setLocale('id');

return $app;
