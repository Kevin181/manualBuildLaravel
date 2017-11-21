<?php
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Fluent;

// Call autoload file
require __DIR__ . '/../vendor/autoload.php';
// Instance the service container
$app = new Illuminate\Container\Container;

Illuminate\Container\Container::setInstance($app);
// Register events service provider
with(new Illuminate\Events\EventServiceProvider($app))->register();
// Register routing service provider
with(new Illuminate\Routing\RoutingServiceProvider($app))->register();
// Launch Eloquent ORM mode and set up
$manager = new Manager();
$manager->addConnection(require '../config/database.php');
$manager->bootEloquent();

$app->instance('config', new Fluent);
$app['config']['view.compiled'] = __DIR__ . "/../storage/framework/views";
$app['config']['view.paths'] = [__DIR__ . '/../resources/views/'];
with(new Illuminate\View\ViewServiceProvider($app))->register();
with(new Illuminate\Filesystem\FilesystemServiceProvider($app))->register();

// Load router
require __DIR__ . '/../app/Http/routes.php';
//Get the instance of request and dispatching requests
$request = Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);
// Return response
$response->send();
