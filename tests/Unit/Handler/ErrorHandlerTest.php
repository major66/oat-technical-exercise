<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Unit\Handler;

use Exception;
use Oat\UserApi\Exception\NotFoundException;
use Oat\UserApi\Handler\ErrorHandler;
use PHPUnit\Framework\TestCase;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class ErrorHandlerTest extends TestCase
{
    public function testItWillReturnAResponseWith404()
    {
        $errorHandler = new ErrorHandler(false);

        $response = $errorHandler->__invoke(
            Request::createFromEnvironment(Environment::mock()),
            (new Response()),
            new NotFoundException('Not found.')
        );

        $responseBody = json_decode((string)$response->getBody(), true);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Not found.', $responseBody['error']);
    }

    public function testItWillReturnAResponseWith500AndDisplayErrorEnabled()
    {
        $errorHandler = new ErrorHandler(true);

        $response = $errorHandler->__invoke(
            Request::createFromEnvironment(Environment::mock()),
            (new Response()),
            new Exception('dummy exception.')
        );

        $responseBody = json_decode((string)$response->getBody(), true);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('dummy exception.', $responseBody['error']);
    }

    public function testItWillReturnAResponseWith500AndDisplayErrorDisabled()
    {
        $errorHandler = new ErrorHandler(false);

        $response = $errorHandler->__invoke(
            Request::createFromEnvironment(Environment::mock()),
            (new Response()),
            new Exception('dummy exception.')
        );

        $responseBody = json_decode((string)$response->getBody(), true);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Internal Server Error.', $responseBody['error']);
    }
}