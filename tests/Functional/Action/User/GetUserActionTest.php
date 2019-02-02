<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Functional\Action\User;

use Oat\UserApi\Tests\Functional\WebTestCase;

class GetUserActionTest extends WebTestCase
{
    public function testItWillRetrieveAUserForAGivenUserId()
    {
        $existingUser = 'fosterabigail';
        $response = $this->runApp('GET', sprintf('/v1/users/%s', $existingUser));

        $this->assertEquals(200, $response->getStatusCode());
        //$this->assertEquals($this->getUserData(), (string)$response->getBody());
    }

    public function testItWillReturn404IfGivenUserIsNotFound()
    {
        //$response = $this->runApp('GET', '/v1/users/nonExistingUser');

        //$this->assertEquals(404, $response->getStatusCode());
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