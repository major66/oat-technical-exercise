<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Unit\Domain\User\Normalizer;

use Oat\UserApi\Domain\User\Model\User;
use Oat\UserApi\Domain\User\Normalizer\UserNormalizer;
use Oat\UserApi\Tests\Unit\Domain\User\DummyUserTrait;
use PHPUnit\Framework\TestCase;

class UserNormalizerTest extends TestCase
{
    use DummyUserTrait;

    /** @var UserNormalizer */
    private $normalizer;

    public function setUp()
    {
        parent::setUp();

        $this->normalizer = new UserNormalizer();
    }

    public function testItWillsupportsDenormalizationForUserModel()
    {
        $this->assertTrue($this->normalizer->supportsDenormalization([], User::class, 'json'));
    }

    public function testItWillsupportsNormalizationForUserModel()
    {
        $this->assertTrue($this->normalizer->supportsNormalization($this->getDummyUser(), 'json'));
    }

    public function testItWillDenormalize()
    {
        /** @var User $user */
        $user = $this->normalizer->denormalize($this->getDummyUserData(), User::class);

        $this->assertInstanceOf(User::class, $user);

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
        /** @var array $user */
        $user = $this->normalizer->normalize($this->getDummyUser());

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

    private function getDummyUser(): User
    {
        $userData = $this->getDummyUserData();
        return new User(
            $userData['login'],
            $userData['password'],
            $userData['title'],
            $userData['lastname'],
            $userData['firstname'],
            $userData['gender'],
            $userData['email'],
            $userData['picture'],
            $userData['address']
        );
    }

    private function getDummyUserData(): array
    {
        return [
            'login' => 'loginTest',
            'password' => 'passwordTest',
            'title' => 'titleTest',
            'lastname' => 'lastnameTest',
            'firstname' => 'firstnameTest',
            'gender' => 'genderTest',
            'email' => 'emailTest',
            'picture' => 'pictureTest',
            'address' => 'addressTest',
        ];
    }
}