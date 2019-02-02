<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Unit\Domain\User\Normalizer;

use Oat\UserApi\Domain\User\Collection\UserCollection;
use Oat\UserApi\Domain\User\Normalizer\UserCollectionNormalizer;
use Oat\UserApi\Tests\Unit\Domain\User\DummyUserTrait;
use PHPUnit\Framework\TestCase;

class UserCollectionNormalizerTest extends TestCase
{
    use DummyUserTrait;

    /** @var UserCollectionNormalizer */
    private $normalizer;

    public function setUp()
    {
        parent::setUp();

        $this->normalizer = new UserCollectionNormalizer();
    }

    public function testItWillsupportsDenormalizationForUserModel()
    {
        $this->assertTrue($this->normalizer->supportsDenormalization([], UserCollection::class, 'json'));
    }

    public function testItWillsupportsNormalizationForUserModel()
    {
        $this->assertTrue($this->normalizer->supportsNormalization($this->getDummyUserCollection(), 'json'));
    }

    public function testItWillDenormalize()
    {
        $userData = $this->getDummyUserData();

        /** @var UserCollection $user */
        $userCollection = $this->normalizer->denormalize([$userData], UserCollection::class);

        $this->assertInstanceOf(UserCollection::class, $userCollection);
        $this->assertEquals(1, $userCollection->count());

        $user = $userCollection->getById($userData['login']);

        $this->assertEquals('loginTest', $user->getLogin());
        $this->assertEquals('titleTest', $user->getTitle());
        $this->assertEquals('passwordTest', $user->getPassword());
        $this->assertEquals('lastnameTest', $user->getLastname());
        $this->assertEquals('firstnameTest', $user->getFirstname());
        $this->assertEquals('genderTest', $user->getGender());
        $this->assertEquals('emailTest', $user->getEmail());
        $this->assertEquals('pictureTest', $user->getPicture());
        $this->assertEquals('addressTest', $user->getAddress());
    }

    public function testItWillNormalize()
    {
        /** @var array $users */
        $users = $this->normalizer->normalize($this->getDummyUserCollection());

        $this->assertEquals(1, count($users));

        $user = current($users);

        $this->assertArrayNotHasKey('password', $user);
        $this->assertEquals('loginTest', $user['login']);
        $this->assertEquals('titleTest', $user['title']);
        $this->assertEquals('lastnameTest', $user['lastname']);
        $this->assertEquals('firstnameTest', $user['firstname']);
        $this->assertEquals('genderTest', $user['gender']);
        $this->assertEquals('emailTest', $user['email']);
        $this->assertEquals('pictureTest', $user['picture']);
        $this->assertEquals('addressTest', $user['address']);
    }
}