<?php


namespace App\Core;


use Psr\Http\Message\ServerRequestInterface;


/**
 * Middleware to decode JSON from the body request
 * Class JsonRequestDecoder
 * @package App\Core
 */
final class JsonRequestDecoder
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $contentType = $request->getHeaderLine('Content-Type');
        if ($contentType === 'application/json') {
            $body = $request->getBody()->getContents();
            $decodedBody = json_decode($body, true);
            $request = $request->withParsedBody($decodedBody);
        }
        return $next($request);
    }
}
