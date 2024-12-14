<?php

namespace App\Services\RabbitMq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqService
{
    private ?AMQPStreamConnection $connection = null;
    private ?AMQPChannel $channel = null;

    public function __construct()
    {
        $this->reconnect();
    }

    public function reconnect()
    {
        $this->closeConnection();
        $this->connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password'),
            config('rabbitmq.vhost'),
            false,
            'AMQPLAIN',
            null,
            'en_US',
            10.0,
            10.0,
            null,
            true,
            60
        );
        $this->channel = $this->connection->channel();
    }

    private function closeConnection()
    {
        if ($this->channel && $this->channel->is_open()) {
            $this->channel->close();
        }
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function consumeMessages(string $queueName, callable $callback): void
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
        $this->channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function publishMessage(string $queueName, string $message): void
    {
        if (!$this->connection || !$this->channel) {
            $this->reconnect();
        }

        $this->channel->queue_declare($queueName, false, true, false, false);
        $msg = new AMQPMessage($message, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($msg, '', $queueName);
    }

    public function __destruct()
    {
        $this->closeConnection();
    }
}
