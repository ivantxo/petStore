<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class GetByUserName
{
    public function __invoke(ServerRequestInterface $request, string $userName)
    {
        return JsonResponse::ok(["message' => 'GET request to /user/$userName}"]);
    }
}
