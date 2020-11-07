<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Users\Storage;
use App\Users\User;


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
        return $this->storage->getByUserName($userName)
            ->then(
                function (User $user) {
                    return JsonResponse::ok(['user' => $user]);
                }
            );
    }
}
