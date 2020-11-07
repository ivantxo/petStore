<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;


use App\Core\JsonResponse;
use App\Users\Storage;
use App\Users\User;
use App\Users\UserNotFound;
use App\Users\UserValidator;


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
        $user = new UserValidator($request);
        $user->validate('update');
        return $this->storage->update($userName, $user->firstName(), $user->lastName(), $user->phone())
            ->then(
                function (User $user) {
                    return JsonResponse::ok(['user' => $user]);
                }
            )
            ->otherwise(
                function (UserNotFound $error) {
                    return JsonResponse::notFound();
                }
            )
            ->otherwise(
                function (NestedValidationException $exception) {
                    return JsonResponse::badRequest(array_values($exception->getMessages()));
                }
            );
    }
}
