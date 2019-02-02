<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Functional;

use DI\Bridge\Slim\App;
use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class WebTestCase extends TestCase
{
    /** @var bool */
    protected $withMiddleware = true;

    /** @var Container */
    protected $container;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Instantiate the application
        $app = new class() extends App {
            protected function configureContainer(ContainerBuilder $builder): void
            {
                $builder->addDefinitions(
                    __DIR__ . '/../../config/settings.php',
                    __DIR__ . '/../../config/definitions.php'
                );
            }
        };

        // Register middleware
        if ($this->withMiddleware) {
            require __DIR__ . '/../../config/middleware.php';
        }

        // Register routes
        require __DIR__ . '/../../config/routes.php';

        // Process the application and return the response
        return $app->process($request, $response);
    }

    public function assertStatusCode(
        int $expectedStatusCode,
        ResponseInterface $response,
        string $message = "The response status code doesn't match."
    ): void {
        $message = $this->createMessageForBodyResponseAssertions($response, $message);
        $this->assertEquals($expectedStatusCode, $response->getStatusCode(), $message);
    }

    public function getResponseBody(ResponseInterface $response): array
    {
        return json_decode((string)$response->getBody(), true);
    }

    private function createMessageForBodyResponseAssertions(ResponseInterface $response, string $message): string
    {
        return sprintf("%s\nBody content: %s", $message, (string)$response->getBody());
    }
}
