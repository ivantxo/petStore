<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Users\Storage;
use App\Users\UserNotFound;


final class UpdateUser
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
        $firstName = $request->getParsedBody()['firstName'];
        $lastName = $request->getParsedBody()['lastName'];
        $phone = $request->getParsedBody()['phone'];
        return $this->storage->update($userName, $firstName, $lastName, $phone)
            ->then(
                function () {
                    return JsonResponse::ok(['user' => 'updated']);
                }
            )
            ->otherwise(
                function (UserNotFound $error) {
                    return JsonResponse::notFound();
                }
            );
    }
}
