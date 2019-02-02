<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Functional\Action\User;

use Oat\UserApi\Tests\Functional\WebTestCase;

class GetUserListActionTest extends WebTestCase
{
    public function testItWillGetAUserListPaginated()
    {
        $response = $this->runApp('GET', '/v1/users?limit=2&offset=1');
        $users = $this->getResponseBody($response)['data'];

        $this->assertStatusCode(200, $response);
        $this->assertCount(2, $users);
        $this->assertEquals('grahamallison', current($users)['login']);
        $this->assertEquals('clarksusan', next($users)['login']);
    }

    public function testItWillGetAUserListPaginatedWithAgivenName()
    {
        $response = $this->runApp('GET', '/v1/users?name=howard&limit=100&offset=0');
        $users = $this->getResponseBody($response)['data'];

        $this->assertStatusCode(200, $response);
        $this->assertCount(2, $users);
        $this->assertEquals('howard', current($users)['lastname']);
        $this->assertEquals('howard', next($users)['lastname']);
    }

    public function testItWillWithNoAUserForAGivenName()
    {
        $response = $this->runApp('GET', '/v1/users?name=nonExistingUser&limit=100&offset=0');

        $this->assertStatusCode(200, $response);
        $this->assertCount(0,  $this->getResponseBody($response)['data']);
    }
}