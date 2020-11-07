<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;


final class DeleteUser
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'DELETE request to /user{username}'])
        );
    }
}
