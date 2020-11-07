<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class DeleteUser
{
    public function __invoke(ServerRequestInterface $request, string $userName)
    {
        return JsonResponse::ok(['message' => "DELETE request to /user/$userName"]);
    }
}
