<?php declare(strict_types=1);

namespace Oat\UserApi\Action\User;

use Oat\UserApi\Repository\User\UserRepositoryInterface;
use Oat\UserApi\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class GetUserListAction
{
    /** @var UserRepositoryInterface */
    private $repository;

    /** @var Responder */
    private $responder;

    public function __construct(UserRepositoryInterface $repository, Responder $responder)
    {
        $this->repository = $repository;
        $this->responder = $responder;
    }

    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        $parameters = $request->getParams();

        $users = $this->repository->findBy(
            $parameters,
            isset($parameters['limit']) ? (int)$parameters['limit'] : 100,
            isset($parameters['offset']) ? (int)$parameters['offset'] : 0
        );

        return $this->responder->respond($response, $users);
    }
}