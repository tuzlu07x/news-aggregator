<?php

namespace App\Services\RabbitMq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqService
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct()
    {

        $this->connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password'),
            config('rabbitmq.vhost'),
        );
        $this->channel = $this->connection->channel();
    }

    public function publishMessage(string $queueName, string $message): void
    {
        $this->channel->queue_declare($queueName, false, true, false, false);

        $msg = new AMQPMessage($message, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($msg, '', $queueName);
    }

    public function consumeMessages(string $queueName, callable $callback): void
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
        $this->channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
