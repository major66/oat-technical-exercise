<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Unit\Domain\User;

use Oat\UserApi\Domain\User\Collection\UserCollection;
use Oat\UserApi\Domain\User\Model\User;

trait DummyUserTrait
{
    public function getDummyUserCollection(): UserCollection
    {
        return (new UserCollection())->add($this->getDummyUserObject());
    }

    public function getDummyUserObject(): User
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

    public function getDummyUserData(): array
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