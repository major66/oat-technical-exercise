<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Functional\Action\User;

use Oat\UserApi\Tests\Functional\WebTestCase;

class GetUserActionTest extends WebTestCase
{
    public function testItWillRetrieveAUserForAGivenUserId()
    {
        $existingUser = 'fosterabigail';
        $response = $this->runApp('GET', sprintf('/v1/users/%s', $existingUser));

        $this->assertStatusCode(200, $response);
        $this->assertEquals($this->getUserData(), $this->getResponseBody($response));
    }

    public function testItWillReturn404IfGivenUserIsNotFound()
    {
        $response = $this->runApp('GET', '/v1/users/nonExistingUser');

        $this->assertStatusCode(404, $response);
        $this->assertEquals(['error' => 'User not found.'], $this->getResponseBody($response));
    }

    private function getUserData(): array
    {
        return [
            "login" => "fosterabigail",
            "title" => "mrs",
            "lastname" => "foster",
            "firstname" => "abigail",
            "gender" => "female",
            "email" => "abigail.foster60@example.com",
            "picture" => "https://api.randomuser.me/0.2/portraits/women/10.jpg",
            "address" => "1851 saddle dr anna 69319",
        ];
    }
}