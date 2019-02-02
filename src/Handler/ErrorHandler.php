<?php declare(strict_types=1);

namespace Oat\UserApi\Handler;

use Oat\UserApi\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Throwable;

class ErrorHandler
{
    /** @var bool */
    private $displayErrorDetails;

    public function __construct(bool $displayErrorDetails)
    {
        $this->displayErrorDetails = $displayErrorDetails;
    }

    public function __invoke(Request $request, Response $response, Throwable $exception): ResponseInterface
    {
        if ($exception instanceof NotFoundException) {
            return $response
                ->withStatus(404)
                ->withJson(['error' => $exception->getMessage()]);
        }

        $message = $this->displayErrorDetails ? $exception->getMessage() : 'Internal Server Error.';

        return $response
            ->withStatus(500)
            ->withJson(['error' => $message]);
    }
}