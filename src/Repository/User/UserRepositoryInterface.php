<?php declare(strict_types=1);

namespace Oat\UserApi\Repository\User;

use Oat\UserApi\Domain\User\Model\User;

interface UserRepositoryInterface
{
    public function findById($id): User;

    public function findBy(array $parameters, int $limit, int $offset): array;
}