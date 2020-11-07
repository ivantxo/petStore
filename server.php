<?php


require __DIR__ . '/vendor/autoload.php';


use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use React\EventLoop\Factory;
use React\Http\Server;
use \React\Socket\Server as Socket;


use App\Core\Router;
use App\Core\ErrorHandler;
use App\Users\Controllers\DeleteUser;
use App\Users\Controllers\GetByUserName;
use App\Users\Controllers\SignInUser;
use App\Users\Controllers\SignUpUser;
use App\Users\Controllers\UpdateUser;


$loop = Factory::create();
$routes = new RouteCollector(new Std(), new GroupCountBased());

// routes
$routes->delete('/user/{username}', new DeleteUser());
$routes->get('/user/login', new SignInUser());
$routes->post('/user', new SignUpUser());
$routes->put('/user/{username}', new UpdateUser());
$routes->get('/user/{username}', new GetByUserName());

$server = new Server(
    $loop,
    new ErrorHandler(),
    new Router($routes)
);

$socket = new Socket('0.0.0.0:8000', $loop);
$server->listen($socket);

echo 'Listening on '
    . str_replace('tcp', 'http', $socket->getAddress())
    . PHP_EOL;

$loop->run();
