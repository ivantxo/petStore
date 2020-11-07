<?php


namespace App\Users\Controllers;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class SignUpUser
{
    public function __invoke(ServerRequestInterface $request)
    {
        $user = [
            'userName' => $request->getParsedBody()['userName'],
            'firstName' => $request->getParsedBody()['firstName'],
            'lastName' => $request->getParsedBody()['lastName'],
            'email' => $request->getParsedBody()['email'],
            'password' => $request->getParsedBody()['password'],
            'phone' => $request->getParsedBody()['phone'],
        ];
        return JsonResponse::ok([
            'message' => 'POST request to /user',
            'user' => $user,
        ]);
    }
}
