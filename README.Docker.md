# Laravel Application with Docker

This project is a Laravel application containerized using Docker. It includes services for PHP, MySQL, Redis, Meilisearch, RabbitMQ, and PhpMyAdmin, all integrated for seamless development.

## Building and Running Your Application

To build and start your application, run the following command:

```bash
docker compose up --build
```

This will:

1. Build the Docker images specified in the `compose.yaml` file.
2. Start the services (Laravel app, MySQL, Redis, Meilisearch, RabbitMQ, PhpMyAdmin).
   After running the above command, your application will be accessible at:

[a link](http://localhost:8000)

## Services Overview

1. `app` (Laravel PHP Application)
   This service runs the Laravel application using Apache and `PHP 8.3`. It includes the necessary PHP extensions like `pdo_pgsql`, `zip`, `pdo_mysql`, and `Redis`.

-   Ports: Exposes port 80 on the container, mapped to port `8000` on your local machine.
-   Environment Variables: The service is configured to connect to the `db`, `redis`, and `meilisearch` services.

2. `db` (MySQL Database)
   This service uses `MySQL 8.0` for the database.

-   Ports: Exposes `port 3306` for database connections.
-   Environment Variables: Configures the MySQL root password and creates a database called `news_aggregator`.

3. `phpmyadmin` (PhpMyAdmin)
   This service allows you to manage your MySQL database through a web interface.

-   Ports: Exposes port 8080 for `PhpMyAdmin`.
-   Environment Variables: Configured to connect to the `db` service.

4. `redis` (Redis Cache)
   This service runs `Redis`, used for `caching` and session management.

Ports: Exposes port `6379`.

5. `meilisearch` (MeiliSearch)
   This service runs MeiliSearch, a fast search engine that integrates with your Laravel application.

Ports: Exposes port `7700`.

6. `rabbitmq` (RabbitMQ)
   This service runs RabbitMQ for message queuing and pub/sub functionality.

Ports: Exposes ports `5672` for RabbitMQ messaging and `15672` for the RabbitMQ management interface.
Environment Variables: Configured with default user `guest` and password `guest`.

## PHP Extensions

The following PHP extensions are included in the Dockerfile for your Laravel application:

`pdo_pgsql`: Required for PostgreSQL database connections.
`zip`: For working with zip files.
`pdo_mysql`: For MySQL database connections.
`redis`: For Redis caching.
`sockets`: For socket support in PHP.
If your application requires additional extensions, you can add them to the Dockerfile under the `docker-php-ext-install` command.

## Environment Variables

You can configure the environment variables in the app service section of docker-compose.yml for database, cache, and search service connections.

`DB_CONNECTION`: Set to mysql for MySQL.
`DB_HOST`: Set to db, pointing to the MySQL service.
`DB_PORT`: Set to 3306 for MySQL.
`DB_DATABASE`: The name of your database, e.g., news_aggregator.
`DB_USERNAME`: MySQL user, set to root.
`DB_PASSWORD`: MySQL password, set to root.
`MEILISEARCH_HOST`: URL for the MeiliSearch service, e.g., http://meilisearch:7700.
