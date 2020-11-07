<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class SignUpUser
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok(['message' => 'POST request to /user']);
    }
}
