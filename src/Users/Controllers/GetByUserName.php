<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Users\Storage;
use App\Users\User;
use App\Users\UserNotFound;


final class GetByUserName
{
    /**
     * @var Storage $storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, string $userName)
    {
        // The controller interacts with the DB in order to get a user by username
        // If the promise returned by getByUserName resolves, then returns a successful response to the customer
        // Otherwise, returns unsuccessful response to the customer
        return $this->storage->getByUserName($userName)
            ->then(
                function (User $user) {
                    return JsonResponse::ok(['user' => $user]);
                }
            )
            ->otherwise(
                function (UserNotFound $error) {
                    return JsonResponse::notFound();
                }
            );
    }
}
