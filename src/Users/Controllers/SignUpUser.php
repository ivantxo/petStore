<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;


use App\Core\JsonResponse;
use App\Users\EmailIsAlreadyTaken;
use App\Users\UserAlreadyExists;
use App\Users\Storage;
use App\Users\UserValidator;


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
        // First the controller validates the request being sent
        $user = new UserValidator($request);
        $user->validate('signup');
        // The controller interacts with the DB in order to signup a user
        // If the promise returned by create resolves, then returns a successful response to the customer
        // Otherwise, there are 3 potential rejections that are returned to the customer
        return $this->storage->create(
            $user->userName(),
            $user->firstName(),
            $user->lastName(),
            $user->email(),
            $user->hashedPassword(),
            $user->phone())
            ->then(
                function () {
                    return JsonResponse::created([]);
                }
            )
            ->otherwise(
                function (UserAlreadyExists $exception) {
                    return JsonResponse::internalServerError('Username is already taken');
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
