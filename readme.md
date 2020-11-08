# petStore RESTful API

This repo contains the code for a small petStore RESTful API

The following endpoints were implemented:
* SignUp user
* Update user
* Get user by username
* Delete user

In order to implement this API I have used [ReactPHP](https://reactphp.org/) which is a library that allows to do Asynchronous programming with PHP or non-blocking PHP.

### How to use this API:

1. Run docker-compose: 

```bash
docker-compose up
```

2. Install Composer dependencies:

```bash
docker-compose exec php composer install
```

3. Execute migrations:

```bash
docker-compose exec php ./vendor/bin/doctrine-migrations migrate
```

4. Run the web server

```bash
docker-compose exec php php server.php
```

Or in watch mode (useful when developing)

```bash
docker-compose exec php ./vendor/bin/php-watcher server.php
```

5. Use [petStore Postman Collention](dev/petStore.postman_collection.json) to send requests.
