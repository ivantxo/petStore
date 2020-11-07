<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class DeleteUser
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok(['message' => 'DELETE request to /user{username}']);
    }
}
