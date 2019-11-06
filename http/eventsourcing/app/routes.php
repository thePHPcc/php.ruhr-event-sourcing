<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Eventsourcing\BillingAddress;
use Eventsourcing\Factory;
use Eventsourcing\SessionId;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    /*
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
    */

    $app->get('/start', function (Request $request, Response $response) {

        $sid = new SessionId('has4t1glskcktjh4ujs9eet26u');

        $factory = new Factory();
        $checkoutService = $factory->createCheckoutService($sid);
        $checkoutService->start();

        $response->getBody()->write('Checkout start <a href="/billingaddress">set billing address</a>');
        return $response;
    });

    $app->get('/billingaddress', function (Request $request, Response $response) {

        $sid = new SessionId('has4t1glskcktjh4ujs9eet26u');

        $factory = new Factory();
        $checkoutService = $factory->createCheckoutService($sid);
        $checkoutService->defineBillingAddress(new BillingAddress());

        $response->getBody()->write('Done. See confirm page <a href="/confirm">here</a>');
        return $response;
    });

    $app->get('/confirm', function (Request $request, Response $response) {
        $sid = new SessionId('has4t1glskcktjh4ujs9eet26u');

        $content = file_get_contents('/tmp/checkout/' . $sid->asString() . '-confirm.html');

        $response->getBody()->write($content);
        return $response;
    });

};
