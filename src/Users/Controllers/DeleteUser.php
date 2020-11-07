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
        return $this->storage->delete($userName)
            ->then(
                function () {
                    return JsonResponse::ok(['user' => 'deleted']);
                }
            )
            ->otherwise(
                function (UserNotFound $error) {
                    return JsonResponse::notFound();
                }
            );
    }
}
