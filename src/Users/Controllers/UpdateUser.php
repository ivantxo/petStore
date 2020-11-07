<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;


use App\Core\JsonResponse;


final class UpdateUser
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok();
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'PUT request to /user/{username}'])
        );
    }
}
