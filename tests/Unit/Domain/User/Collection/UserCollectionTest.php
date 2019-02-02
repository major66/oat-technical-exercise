<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Unit\Domain\User\Collection;

use Oat\UserApi\Domain\User\Collection\UserCollection;
use Oat\UserApi\Tests\Functional\WebTestCase;
use Oat\UserApi\Tests\Unit\Domain\User\DummyUserTrait;

class UserCollectionTest extends WebTestCase
{
    use DummyUserTrait;

    public function testItWillAddAUserToTheCollection()
    {
        $userCollection = new UserCollection();
        $user = $this->getDummyUserObject();

        $this->assertEquals(0, $userCollection->count());

        $userCollection->add($user);

        $this->assertEquals(1, $userCollection->count());
    }

    public function testItwillAddAllTheUserToTheCollection()
    {
        $userCollection = new UserCollection();
        $users = [
            $this->getDummyUserObject()->setLogin('test'),
            $this->getDummyUserObject(),
        ];
        $this->assertEquals(0, $userCollection->count());

        $userCollection->addAll($users);

        $this->assertEquals(2, $userCollection->count());
    }

    public function testItWillRetrieveAllTheUserOfTheCollection()
    {
        $userCollection = new UserCollection();
        $userCollection->addAll([
            $this->getDummyUserObject()->setLogin('test'),
            $this->getDummyUserObject(),
        ]);

        $users = $userCollection->getAllUsers();

        $this->assertEquals(2, count($users));
        $this->assertEquals('test', current($users)->getLogin());
        $this->assertEquals('loginTest', next($users)->getLogin());
    }

    public function testItWillRetrieveAUserById()
    {
        $userCollection = new UserCollection();
        $userCollection->addAll([
            $this->getDummyUserObject()->setLogin('goodId'),
            $this->getDummyUserObject()->setLogin('badId'),
        ]);

        $user = $userCollection->getById('goodId');

        $this->assertEquals('goodId', $user->getLogin());
    }
}