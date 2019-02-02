<?php declare(strict_types=1);

namespace Oat\UserApi\Domain\User\Collection;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Oat\UserApi\Domain\User\Model\User;

class UserCollection implements IteratorAggregate, Countable
{
    /** @var User[] */
    private $users = [];

    public function add(User $user): self
    {
        $this->users[$user->getLogin()] = $user;

        return $this;
    }

    public function addAll(array $users): self
    {
        /** @var User $user */
        foreach ($users as $user) {
            $this->users[$user->getLogin()] = $user;
        }

        return $this;
    }

    public function getAllUsers(): array
    {
        return $this->users;
    }

    public function getById(string $id): ?User
    {
        return $this->users[$id] ?? null;
    }

    public function getIterator()
    {

        return new ArrayIterator($this->users);
    }

    public function count()
    {
        return count($this->users);
    }
}