<?php


namespace App\Users\Controllers;


use App\Users\EmailIsAlreadyTaken;
use App\Users\UserAlreadyExists;
use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Users\Storage;


final class SignUpUser
{
    /**
     * @var Storage $storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $userName = $request->getParsedBody()['userName'];
        $firstName = $request->getParsedBody()['firstName'];
        $lastName = $request->getParsedBody()['lastName'];
        $email = $request->getParsedBody()['email'];
        $password = $request->getParsedBody()['password'];
        $phone = $request->getParsedBody()['phone'];
        return $this->storage->create($userName, $firstName, $lastName, $email, $password, $phone)
            ->then(
                function () {
                    return JsonResponse::ok(['user' => 'created']);
                }
            )
            ->otherwise(
                function (UserAlreadyExists $exception) {
                    return JsonResponse::internalServerError('User already exists');
                }
            )
            ->otherwise(
                function (EmailIsAlreadyTaken $exception) {
                    return JsonResponse::internalServerError('Email is already taken');
                }
            );
    }
}
