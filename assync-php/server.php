<?php
require __DIR__ . '/vendor/autoload.php';

use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\HttpServer;
use Amp\Socket\Server;
use Psr\Log\NullLogger;
use \Amp\Http\Server\Router;
use App\Model\DBModel;
use App\Controller\TestController;

$configPath = __dir__ . '/config/config.php';

Amp\Loop::run(function () use ($configPath) {
    $sockets = [
        Server::listen("0.0.0.0:1337"),
        Server::listen("[::]:1337"),
    ];

    $dbModel = new DBModel(new \App\Util\Config($configPath));
    $controller = new TestController($dbModel);
    $router = new Router();

    $router->addRoute('GET', '/test', new CallableRequestHandler(function() use ($controller) {
        return $controller->test();
    }));

    $server = new HttpServer($sockets, $router, new NullLogger());

    yield $server->start();

    Amp\Loop::onSignal(SIGINT, function (string $watcherId) use ($server) {
        Amp\Loop::cancel($watcherId);
        yield $server->stop();
    });
});



