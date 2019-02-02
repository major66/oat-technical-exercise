<?php declare(strict_types=1);

namespace Oat\UserApi\Tests\Unit\Responder;

use Oat\UserApi\Domain\User\Collection\UserCollection;
use Oat\UserApi\Domain\User\Normalizer\UserCollectionNormalizer;
use Oat\UserApi\Responder\Responder;
use Oat\UserApi\Tests\Unit\Domain\User\DummyUserTrait;
use PHPUnit\Framework\TestCase;
use Slim\Http\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ResponderTest extends TestCase
{
    use DummyUserTrait;

    /** @var Serializer */
    private $serializer;

    public function setUp()
    {
        parent::setUp();
        $normalizers = [new UserCollectionNormalizer()];
        $encoders = ['json' => new JsonEncoder()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function testItWillReturnAProperResponse()
    {
        $responder = new Responder($this->serializer);

        $data = (new UserCollection())->add($this->getDummyUserObject());
        $expectedJson = $this->serializer->serialize($data, 'json');
        $expectedHeader = [
            'Content-Type' => 'application/json;charset=utf-8'
        ];
        $response = $responder->respond((new Response()), $data);

        $this->assertEquals(200, (int)$response->getStatusCode());
        $this->assertEquals($expectedJson, (string)$response->getBody());
        $this->assertEquals($expectedHeader['Content-Type'], current($response->getHeader('Content-Type')));
    }
}