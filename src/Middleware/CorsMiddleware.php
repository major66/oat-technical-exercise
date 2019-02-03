<?php declare(strict_types=1);

namespace Oat\UserApi\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class CorsMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        /** @var Response $response */
        $response = $next($request, $response);

        return $response
            ->withHeader('Access-Control-Allow-Methods', 'GET')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
    }
}