<?php

require __DIR__ . '/vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$socket = new \React\Socket\Server('127.0.0.1:8080', $loop);

$socket->on('connection', function (\React\Socket\ConnectionInterface $connection){
    $connection->write('Hello, user');

    $connection->on('data', function($data) use ($connection) {
        $connection->close();
    });
});

$loop->run();