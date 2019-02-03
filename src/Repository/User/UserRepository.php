<?php declare(strict_types=1);

namespace Oat\UserApi\Repository\User;

use Oat\UserApi\Domain\User\Collection\UserCollection;
use Oat\UserApi\Domain\User\Exception\UserNotFoundException;
use Oat\UserApi\Domain\User\Model\User;

class UserRepository implements UserRepositoryInterface
{
    /** @var UserCollection */
    private $users;

    public function __construct(UserCollection $users) {
        $this->users = $users;
    }

    public function findById($id): User
    {
        $user = $this->users->getById($id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function findBy(array $parameters, int $limit, int $offset): array
    {
        if (isset($parameters['name'])) {
            return $this->getPaginatedUsersByName($this->users, $parameters['name'], $limit, $offset);
        }

        return $this->filterCollectionByPagination($this->users, $limit, $offset);
    }

    private function getPaginatedUsersByName(UserCollection $users, string $name, int $limit, int $offset)
    {
        $usersWithMatchingName = new UserCollection();

        /** @var User $user */
        foreach ($users as $user) {
            if (stripos($user->getFirstname(), $name) !== false || stripos($user->getLastname(), $name) !== false) {
                $usersWithMatchingName->add($user);
            }
        }

        return $this->filterCollectionByPagination($usersWithMatchingName, $limit, $offset);
    }

    private function filterCollectionByPagination(UserCollection $users, int $limit, int $offset): array
    {
        $returnedUsers = [];
        $countOffset = 0;
        $countLimit = 0;
        foreach ($users as $user) {
            if ($offset > $countOffset) {
                $countOffset++;
                continue;
            }

            $returnedUsers[] = $user;
            $countLimit++;

            if ($limit == $countLimit) {
                break;
            }
        }

        return [
            'limit' => $limit,
            'offset' => $offset,
            'total' => count($users),
            'data' => $returnedUsers,
        ];
    }
}