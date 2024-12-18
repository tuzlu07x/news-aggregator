# News Aggregator Task Case

## Summary

The News Aggregator project is a Laravel-based application designed to fetch, process, and recommend news articles from various APIs like NewsAPI, World News API, and New York Times API. It leverages modern technologies and best practices, including dependency injection, microservice patterns, and containerized development environments.

### Key Features:

1. News Fetching & Aggregation:

-   Fetches news articles from multiple APIs, each with its unique command for execution.
-   Implements rate-limiting and pagination where supported, ensuring optimal API usage.

2. Recommendation System:

-   Uses RabbitMQ with a pub/sub pattern to recommend articles to users based on their preferences.
-   Ensures efficient message processing with a queue worker system.

3. Search and Filtering:

-   Integrated Meilisearch for fast and intuitive search functionality.
-   Articles can be filtered by categories, sources, titles, content, and publication date.

4. Containerization:

-   Utilizes Docker for environment setup and management.
-   Ensures the project can run consistently across different systems.

5. Database Management:

-   MySQL is used as the primary database.
-   Supports database migrations and seeding to prepopulate data.

6. Background Jobs:

-   Redis is employed for queue management.
-   Background processes like fetching news and processing recommendations are run using Laravel’s queue system.

7. API Documentation & Testing:

-   API endpoints are documented with Swagger and can be tested with Postman collections.
-   Uses PEST Framework for feature and unit tests to ensure code reliability.

## Requirements

Before starting, ensure you have the following installed on your system:

`PHP`: Version 8.3

`Laravel`: Version 11

`Composer`: Latest version

`Docker`: For containerized environment setup

## Installation

1. First off all Let's `clone` the project

```bash
git clone git@github.com:tuzlu07x/news-aggregator.git
```

2. Run below command after open the project on editor

```bash
composer install
```

3. Copy the `/.env.example` file and change with `.env`

-   For Macos or Linux

```bash
cp .env.example .env
```

-   For Windows

```bash
Copy-Item .env.example .env
```

## ENV

`.env`: now set your API Keys as a below

`NEWS_API_KEY`=[news_api_key](https://newsapi.org/) <br>
`WORLD_NEWS_API_KEY`= [world_news](https://worldnewsapi.com/) <br>
`NY_TIMES_API_KEY`= [new_york_times](https://developer.nytimes.com/get-started)

`MEILISEARCH_KEY`=masterKey

## POSTMAN

You can visit `Postman` endpoint and can visit `Swagger` Document below links <br>

[Link of Postman Enpoints](https://dark-station-425448.postman.co/workspace/News-Aggregator~1b19db34-ac72-4f12-aa8f-21ff162b9d4a/collection/20110215-cb8c5ca0-5704-456d-8e01-0f601c36e041?action=share&creator=20110215)

[Swagger API Document](https://app.swaggerhub.com/apis/FATIHTUZLU07/news-task/1.0.0)

## Docker

Visit Docker readme file and act like there

`/README.Docker.md`

### Docker Run Command

You can find everything about docker In `README.Docker.md` file if you did not visit there yet please before starting visit there

To build and start your application, run the following command:

```bash
docker compose up --build
```

## MySQL

Please Migrate all migrations to database

```bash
php artisan migrate --seed
```

## News Commands

If everything OK we can countunie run commands which are news aggregator. Also you can visit `app/Console/Kernel.php` to see them

1. firstly, run `queue` command

```bash
php artisan queue:work
```

2. Run `newsApi` command

-`info`: If you use free plan newsApi allows you just `100` request that's why I developed its job according to it.

```bash
php artisan get:newsApi
```

3. Run `nyTimesNewsApi` command

```bash
php artisan get:nyTimesNewsApi
```

4. Run `worldNewsApi` command

-`info` I haven't seen any pagination for this configuration that's why I haven't set its pagination in job and I got daily record.

```bash
php artisan get:worldNewsApi
```

You can find their `configuration` files on `app/News` path

## Recommendation

For Recommendation I decided to use `RabbitMQ` and used `pub/sub pattern` for this

-   You can find consumer, publisher and management service inside `app/Services/Rabbitmq` path

### Command

Please make sure to check `php artisan migrate --seed` and make sure yourself to run `articles` commands before run below command

-   this command will set that user recommend news acording to user preference

```bash
php artisan start:rabbitMqPublisherAndConsumer
```

-   After that run below command

```bash
php artisan queue:work
```

-   Now You can visit `POSTMAN` and request the `News Aggregator/Recommendation/Recommend` path

```bash
curl --location 'http://localhost:8000/api/recommendations?page=1' \
--header 'Accept: application/json' \
--header 'Authorization: ••••••' \
```

## Filtering

1. For filtering I have decided to use `Meilisearch` and before check the endpoind of the `meilisearch` you have to run these commands

```bash
php artisan scout:import "App\Models\Article"
php artisan scout:index "App\Models\Article"
php artisan scout:sync-index-settings

```

2. And Finaly run

```bash
php artisan queue:work
```

3. After run these commands you can visit the `http://localhost:7700/` address to se all articles which is indexed

4. Now You can visit `POSTMAN` link to request. The path `News/News Aggregator/Article/Searh`

I set them for searching

```php
<?php
namespace App\Models;

'title' => $this->title,
'content' => $this->content,
'category' => $this->category,
'source' => $this->source,
'published_at' => $this->published_at,
```

5. Also Parameters Example as below. In `filter` parameter you can add `published_at, title and content` too. You can also use `q=` parameter

````bash
curl --location 'http://127.0.0.1:7700/indexes/articles/search \
--params 'q=*'
--params 'filter=(category='technology' OR source='Forbes')'
--header 'Accept: application/json' \
--header 'Authorization: ••••••'```
````

# Test

For Testing I prepared with `PEST Framework` you can find them on `/test/Feature` and `/test/Unit` path

```bash
php artisan test
```
