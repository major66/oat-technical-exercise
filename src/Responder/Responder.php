<?php declare(strict_types=1);

namespace Oat\UserApi\Responder;

use Slim\Http\Response;
use Symfony\Component\Serializer\Serializer;

class Responder
{
    /** @var Serializer */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function respond(Response $response, $data, int $statusCode = 200): Response
    {
        $response
            ->write($this->serializer->serialize($data, 'json'))
            ->withStatus($statusCode);

        return $response->withHeader('Content-Type', 'application/json;charset=utf-8');
    }
}