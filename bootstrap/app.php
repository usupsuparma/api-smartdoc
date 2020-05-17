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
$app->configure('tcpdf');
$app->configure('onesignal');
// $app->configure('services');

$app->withFacades(true, [
    App\Library\Managers\Navigation\Facade\Navigation::class => 'Navigation',
    App\Library\Managers\Authority\Facade\Authority::class => 'Authority',
    Illuminate\Support\Facades\Mail::class => 'Mail',
    App\Library\Managers\Smartdoc\Facade\Smartdoc::class => 'Smartdoc',
    App\Library\Managers\Upload\Facade\Upload::class => 'Upload',
    App\Library\Managers\DigitalSign\Facade\DigitalSign::class => 'DigitalSign',
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
$app->register(App\Library\Managers\Smartdoc\Providers\SmartdocServiceProvider::class);
$app->register(App\Library\Managers\Upload\Providers\UploadServiceProvider::class);
$app->register(App\Library\Managers\DigitalSign\Providers\DigitalSignServiceProvider::class);

/* Modules */
$app->register(App\Modules\Auth\Providers\AuthServiceProvider::class);
$app->register(App\Modules\Test\Providers\TestServiceProvider::class);
$app->register(App\Modules\User\Providers\UserServiceProvider::class);
$app->register(App\Modules\Menu\Providers\MenuServiceProvider::class);
$app->register(App\Modules\Role\Providers\RoleServiceProvider::class);
$app->register(App\Modules\Setting\Providers\SettingServiceProvider::class);
$app->register(App\Modules\OutgoingMail\Providers\OutgoingMailServiceProvider::class);
$app->register(App\Modules\OutgoingMail\Providers\AdminOutgoingMailServiceProvider::class);
$app->register(App\Modules\OutgoingMail\Providers\ApprovalOutgoingMailServiceProvider::class);
$app->register(App\Modules\OutgoingMail\Providers\SignedOutgoingMailServiceProvider::class);
$app->register(App\Modules\IncomingMail\Providers\IncomingMailServiceProvider::class);
$app->register(App\Modules\Disposition\Providers\DispositionServiceProvider::class);
$app->register(App\Modules\Disposition\Providers\DispositionFollowServiceProvider::class);
$app->register(App\Modules\Notification\Providers\NotificationServiceProvider::class);
$app->register(App\Modules\Verification\Providers\VerificationServiceProvider::class);

$app->register(App\Modules\Review\Providers\ReviewServiceProvider::class);
$app->register(App\Modules\Signature\Providers\SignatureServiceProvider::class);
$app->register(App\Modules\MappingStructure\Providers\MappingStructureServiceProvider::class);

$app->register(App\Modules\Master\Type\Providers\TypeServiceProvider::class);
$app->register(App\Modules\Master\Classification\Providers\ClassificationServiceProvider::class);
$app->register(App\Modules\Master\ClassDisposition\Providers\ClassDispositionServiceProvider::class);
$app->register(App\Modules\Master\TypeNote\Providers\TypeNoteServiceProvider::class);
$app->register(App\Modules\Master\Template\Providers\TemplateServiceProvider::class);

/* Report */
$app->register(App\Modules\Report\Outgoing\Providers\ReportOutgoingServiceProvider::class);
$app->register(App\Modules\Report\Incoming\Providers\ReportIncomingServiceProvider::class);

/* External */
$app->register(App\Modules\External\Employee\Providers\EmployeeServiceProvider::class);
$app->register(App\Modules\External\Organization\Providers\OrganizationServiceProvider::class);
$app->register(App\Modules\External\Position\Providers\PositionServiceProvider::class);

/* Core */
$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);

/* Mail */
$app->register(Illuminate\Mail\MailServiceProvider::class);
$app->alias('mailer', Illuminate\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);

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

/* QRcode */
$app->register(SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class);
class_alias(SimpleSoftwareIO\QrCode\Facades\QrCode::class, 'QrCode');

/* OneSignal */
$app->register(Berkayk\OneSignal\OneSignalServiceProvider::class);
class_alias(Berkayk\OneSignal\OneSignalFacade::class, 'OneSignal');

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
