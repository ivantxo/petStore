<?php


namespace App\Core;


use Psr\Http\Message\ServerRequestInterface;
use \Throwable;
use React\Http\Message\Response;
use Respect\Validation\Exceptions\NestedValidationException;
use function React\Promise\resolve;


/**
 * Middleware to display errors nicely
 * Class ErrorHandler
 * @package App\Core
 */
final class ErrorHandler
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return resolve($next($request))
                ->then(
                    function (Response $response) {
                        return $response;
                    },
                    function (Throwable $error) {
                        return $this->handleThrowable($error);
                    }
                );
        } catch (NestedValidationException $exception) {
            return JsonResponse::badRequest(array_values($exception->getMessages()));
        } catch (Throwable $error) {
            return $this->handleThrowable($error);
        }
    }

    public function handleThrowable(Throwable $error): Response
    {
        return JsonResponse::internalServerError($error->getMessage());
    }
}
