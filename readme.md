# petStore RESTful API

This repo contains the code for a small petStore RESTful API

The following endpoints were implemented:
* SignUp user
* Update user
* Get user by username
* Delete user

In order to implement this API I have used [ReactPHP](https://reactphp.org/) which is a library that allows to do Asynchronous programming with PHP or non-blocking PHP. Therefore the code is event-driven (when a new request arrives an event is fired, a callback is called, event handler is executed). The application is organised as follows:
* Migrations: Migrations folder
* src: Main src code
  * Core: Web server middlewares
  * Users: All related to the users logic
    * Controllers: Or Endpoints logic
      * DeleteUser.php (implemented)
      * GetByUserName.php (implemented)
      * SignUpUser.php (implemented)
      * UpdateUser.php (implemented)
  * Categories: All related to the categories logic should go here (not implemented)
  * Pets: All related to the pets logic should go here (not implemented)
  * Stores: All related to the stores logic should go here (not implemented)
  * Tags: All related to the tags logic should go here (not implemented)
* tests: All tests should go here

### How to use this API:

1. Create a .env file and make sure your DB credentials are ok

```bash
cp .env.dist .env
```

2. Check that the DB credentials on docker-composer.yml are ok

3. Run docker-compose: 

```bash
docker-compose up
```

4. Install Composer dependencies:
 
```bash
docker-compose exec php composer install
```

5. Execute migrations:

```bash
docker-compose exec php ./vendor/bin/doctrine-migrations migrate
```

6. Run the web server

```bash
docker-compose exec php php server.php
```

Or in watch mode (useful when developing)

```bash
docker-compose exec php ./vendor/bin/php-watcher server.php
```

5. Use [petStore Postman Collention](dev/petStore.postman_collection.json) to send requests.
