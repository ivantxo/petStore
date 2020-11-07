<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;


final class GetByUserName
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'GET request to /user/{username}'])
        );
    }
}