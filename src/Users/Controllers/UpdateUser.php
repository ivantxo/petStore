<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class UpdateUser
{
    public function __invoke(ServerRequestInterface $request, string $userName)
    {
        return JsonResponse::ok(['message' => "PUT request to /user/$userName"]);
    }
}
