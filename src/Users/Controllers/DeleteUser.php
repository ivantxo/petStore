<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Users\Storage;
use App\Users\UserNotFound;


final class DeleteUser
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
        // The controller interacts with the DB in order to delete a user
        // If the promise returned by delete resolves, then returns a successful response to the customer
        // Otherwise, returns unsuccessful response to the customer
        return $this->storage->delete($userName)
            ->then(
                function () {
                    return JsonResponse::ok([]);
                }
            )
            ->otherwise(
                function (UserNotFound $error) {
                    return JsonResponse::notFound();
                }
            );
    }
}
