<?php


require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('172.18.0.2', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('pruebas', 'topic', false, false, false);

$queue_name = "pp";

    $channel->queue_bind($queue_name, 'pruebas', "Telfy.Events.#");


echo " [*] Waiting for logs. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connection->close();