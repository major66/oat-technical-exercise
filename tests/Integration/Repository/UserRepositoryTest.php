<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Integration\Repository;

use Oat\UserApi\Domain\User\Collection\UserCollection;
use Oat\UserApi\Domain\User\Model\User;
use Oat\UserApi\Domain\User\Normalizer\UserCollectionNormalizer;
use Oat\UserApi\Repository\User\UserRepository;
use Oat\UserApi\Tests\Functional\WebTestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class UserRepositoryTest extends WebTestCase
{
    /** @var UserRepository */
    private $repository;

    public function setUp()
    {
        parent::setUp();

        $serializer = new Serializer([new UserCollectionNormalizer()], ['json' => new JsonEncoder()]);
        $filePath = __DIR__ . '/../../../dataSource/Json/testtakers.json';
        /** @var UserCollection $users */
        $users = $serializer->deserialize(file_get_contents($filePath), UserCollection::class, 'json');

        $this->repository = new UserRepository($users);
    }

    public function testItWillFindAUserById()
    {
        $user = $this->repository->findById('fosterabigail');

        $this->userVerifier($user);
    }

    public function testItWillReturnAUserListPaginated()
    {
        $usersPaginated = $this->repository->findBy([], 3, 0);
        $users = $usersPaginated['data'];

        $this->assertEquals(3, $usersPaginated['limit']);
        $this->assertEquals(0, $usersPaginated['offset']);
        $this->assertEquals(100, $usersPaginated['total']);
        $this->assertEquals(3, count($users));
        $this->assertEquals('fosterabigail', current($users)->getLogin());
        $this->assertEquals('grahamallison', next($users)->getLogin());
        $this->assertEquals('clarksusan', next($users)->getLogin());

        $usersPaginated = $this->repository->findBy([], 2, 1);
        $users = $usersPaginated['data'];

        $this->assertEquals(2, $usersPaginated['limit']);
        $this->assertEquals(1, $usersPaginated['offset']);
        $this->assertEquals(100, $usersPaginated['total']);
        $this->assertEquals(2, count($users));
        $this->assertEquals('grahamallison', current($users)->getLogin());
        $this->assertEquals('clarksusan', next($users)->getLogin());
    }

    public function testItWillReturnAUserListPaginatedForAGivenName()
    {
        $userNameContained = 'foster';
        $usersPaginated = $this->repository->findBy(['name' => $userNameContained], 3, 0);
        $users = $usersPaginated['data'];

        $this->assertEquals(3, $usersPaginated['limit']);
        $this->assertEquals(0, $usersPaginated['offset']);
        $this->assertEquals(3, $usersPaginated['total']);
        $this->assertEquals(3, count($users));

        $this->userVerifier(current($users));

        $this->assertEquals($userNameContained, current($users)->getLastName());
        $this->assertEquals($userNameContained, next($users)->getLastName());
        $this->assertEquals($userNameContained, next($users)->getLastName());
    }

    private function userVerifier(User $user)
    {
        $this->assertEquals('fosterabigail', $user->getLogin());
        $this->assertEquals('mrs', $user->getTitle());
        $this->assertEquals('foster', $user->getLastname());
        $this->assertEquals('abigail', $user->getFirstname());
        $this->assertEquals('female', $user->getGender());
        $this->assertEquals('abigail.foster60@example.com', $user->getEmail());
        $this->assertEquals('https://api.randomuser.me/0.2/portraits/women/10.jpg', $user->getPicture());
        $this->assertEquals('1851 saddle dr anna 69319', $user->getAddress());
    }
}