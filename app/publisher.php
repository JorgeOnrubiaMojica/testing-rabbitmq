<?php


require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('172.18.0.2', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('pruebas', 'topic', false, false, false);
$data = "Hello World!";


$msg = new AMQPMessage($data);
$startTime = time();
for ($i = 0; $i < 200000 ; $i++) {
    $channel->basic_publish($msg, 'pruebas', 'Telfy.Event.Aloha');
}
$endTime = time();
echo date("H:i:s", $startTime);
echo date("H:i:s", $endTime);

$channel->close();
$connection->close();


