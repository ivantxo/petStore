<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class SignInUser
{
    public function __invoke(ServerRequestInterface $request)
    {
        // Signin was not fully implemented, but still if requested it will return a message
        return JsonResponse::ok(['message' => 'GET request to /user/login']);
    }
}
