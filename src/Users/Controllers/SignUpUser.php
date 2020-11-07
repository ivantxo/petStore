<?php


namespace App\Users\Controllers;


use Exception;
use Psr\Http\Message\ServerRequestInterface;


use App\Users\EmailIsAlreadyTaken;
use App\Users\UserAlreadyExists;
use App\Core\JsonResponse;
use App\Users\Storage;
use App\Users\UserValidator;
use Respect\Validation\Exceptions\NestedValidationException;


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
        $password = $request->getParsedBody()['password'];
        $user = new UserValidator($request);
        $user->validate();
        return $this->storage->create(
            $user->userName(),
            $user->firstName(),
            $user->lastName(),
            $user->email(),
            $password,
            $user->phone())
            ->then(
                function () {
                    return JsonResponse::created([]);
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
            )
            ->otherwise(
                function (NestedValidationException $exception) {
                    return JsonResponse::badRequest(array_values($exception->getMessages()));
                }
            );
    }
}
