<?php declare(strict_types=1);

namespace Oat\UserApi\Action\User;

use Oat\UserApi\Domain\User\Exception\UserNotFoundException;
use Oat\UserApi\Exception\NotFoundException;
use Oat\UserApi\Repository\User\UserRepositoryInterface;
use Oat\UserApi\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

class GetUserAction
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

    public function __invoke(Response $response, string $id): ResponseInterface
    {
        try {
            $user = $this->repository->findById($id);
        } catch (UserNotFoundException $exception) {
            throw new NotFoundException($exception->getMessage());
        }

        return $this->responder->respond($response, $user);
    }
}